<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\User;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\TradeProposed; // <- Import toevoegen
use App\Notifications\TradeAccepted; // <- Import toevoegen
use App\Notifications\TradeDeclined; // <- Import toevoegen

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $sentTrades = $user->sentTrades()->with(['receiver', 'offeredItems.item', 'requestedItems.item'])->get();
        $receivedTrades = $user->receivedTrades()->with(['sender', 'offeredItems.item', 'requestedItems.item'])->get();

        return view('trades.index', compact('sentTrades', 'receivedTrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get(); // alle andere spelers
        $myItems = auth()->user()->inventories()->with('item')->get();
        $allItems = Item::all(); // voor gevraagde items

        return view('trades.create', compact('users', 'myItems', 'allItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'offered_items' => 'required|array',
            'offered_items.*.item_id' => 'required|exists:items,id',
            'offered_items.*.quantity' => 'required|integer|min:1',
            'requested_items' => 'sometimes|array',
            'requested_items.*.item_id' => 'required_with:requested_items|exists:items,id',
            'requested_items.*.quantity' => 'required_with:requested_items|integer|min:1',
        ]);

        // Controleer of de speler de aangeboden items in voldoende hoeveelheid bezit
        foreach ($request->offered_items as $offer) {
            $inventory = Inventory::where('user_id', auth()->id())
                ->where('item_id', $offer['item_id'])
                ->first();

            if (!$inventory || $inventory->quantity < $offer['quantity']) {
                return back()->withErrors(['offered_items' => 'Je hebt niet genoeg van dit item: ' . $offer['item_id']]);
            }
        }

        // Maak trade aan in een transactie
        try {
            DB::beginTransaction();

            $trade = Trade::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'status' => 'pending',
            ]);

            // Voeg aangeboden items toe
            foreach ($request->offered_items as $offer) {
                $trade->offeredItems()->create([
                    'item_id' => $offer['item_id'],
                    'quantity' => $offer['quantity'],
                ]);
            }

            // Voeg gevraagde items toe
            if ($request->has('requested_items')) {
                foreach ($request->requested_items as $requested) {
                    $trade->requestedItems()->create([
                        'item_id' => $requested['item_id'],
                        'quantity' => $requested['quantity'],
                    ]);
                }
            }

            DB::commit();

            // Stuur notificatie naar ontvanger - HAAL COMMENT WEG
            $receiver = User::find($request->receiver_id);
            $receiver->notify(new TradeProposed($trade));

            return redirect()->route('trades.index')->with('success', 'Handelsvoorstel verzonden.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Trade $trade)
    {
        // Alleen betrokken partijen mogen de trade zien
        if ($trade->sender_id !== auth()->id() && $trade->receiver_id !== auth()->id()) {
            abort(403);
        }

        $trade->load(['sender', 'receiver', 'offeredItems.item', 'requestedItems.item']);

        return view('trades.show', compact('trade'));
    }

    /**
     * Accept a trade.
     */
    public function accept(Trade $trade)
    {
        // Alleen ontvanger mag accepteren
        if ($trade->receiver_id !== auth()->id() || $trade->status !== 'pending') {
            abort(403);
        }

        // Controleer of ontvanger de gevraagde items nog heeft
        foreach ($trade->requestedItems as $req) {
            $inventory = Inventory::where('user_id', $trade->receiver_id)
                ->where('item_id', $req->item_id)
                ->first();
            if (!$inventory || $inventory->quantity < $req->quantity) {
                return back()->withErrors('Je hebt niet meer genoeg van ' . $req->item->name);
            }
        }

        // Controleer of verzender de aangeboden items nog heeft
        foreach ($trade->offeredItems as $off) {
            $inventory = Inventory::where('user_id', $trade->sender_id)
                ->where('item_id', $off->item_id)
                ->first();
            if (!$inventory || $inventory->quantity < $off->quantity) {
                return back()->withErrors('De verzender heeft niet meer genoeg van ' . $off->item->name);
            }
        }

        // Voer ruil uit in een transactie
        try {
            DB::beginTransaction();

            // Verzender verliest aangeboden items, ontvanger krijgt ze
            foreach ($trade->offeredItems as $off) {
                $this->decreaseInventory($trade->sender_id, $off->item_id, $off->quantity);
                $this->increaseInventory($trade->receiver_id, $off->item_id, $off->quantity);
            }

            // Ontvanger verliest gevraagde items, verzender krijgt ze
            foreach ($trade->requestedItems as $req) {
                $this->decreaseInventory($trade->receiver_id, $req->item_id, $req->quantity);
                $this->increaseInventory($trade->sender_id, $req->item_id, $req->quantity);
            }

            $trade->update(['status' => 'accepted']);

            DB::commit();

            // Notificeer verzender - HAAL COMMENT WEG
            $trade->sender->notify(new TradeAccepted($trade));

            return redirect()->route('trades.index')->with('success', 'Ruil geaccepteerd!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }

    /**
     * Decline a trade.
     */
    public function decline(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id() || $trade->status !== 'pending') {
            abort(403);
        }

        $trade->update(['status' => 'declined']);

        // Notificeer verzender - HAAL COMMENT WEG
        $trade->sender->notify(new TradeDeclined($trade));

        return redirect()->route('trades.index')->with('success', 'Voorstel geweigerd.');
    }

    private function decreaseInventory($userId, $itemId, $quantity)
    {
        $inv = Inventory::where('user_id', $userId)->where('item_id', $itemId)->first();
        if ($inv) {
            if ($inv->quantity <= $quantity) {
                $inv->delete();
            } else {
                $inv->decrement('quantity', $quantity);
            }
        }
    }

    private function increaseInventory($userId, $itemId, $quantity)
    {
        $inv = Inventory::firstOrCreate(
            ['user_id' => $userId, 'item_id' => $itemId],
            ['quantity' => 0]
        );
        $inv->increment('quantity', $quantity);
    }
}
