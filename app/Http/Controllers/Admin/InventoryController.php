<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Toon een overzicht van alle toegekende items (index pagina)
     */
    public function index(Request $request)
    {
        $query = Inventory::with(['user', 'item']);

        // Filter op gebruiker
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter op item
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $inventories = $query->latest()->paginate(15);
        $users = User::where('role', 'player')->get();
        $items = Item::all();

        return view('admin.assign-item-index', compact('inventories', 'users', 'items'));
    }

    /**
     * Toon het formulier om een item toe te kennen
     */
    public function assignForm(Request $request)
    {
        $users = User::where('role', 'player')->get();
        $items = Item::all();

        // Als er een user_id is meegegeven via de URL, selecteer die dan automatisch
        $selectedUserId = $request->get('user_id');

        return view('admin.assign-item', compact('users', 'items', 'selectedUserId'));
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Controleer of het item al bestaat in de inventaris van de gebruiker
        $inventory = Inventory::where('user_id', $validated['user_id'])
            ->where('item_id', $validated['item_id'])
            ->first();

        if ($inventory) {
            // Als het item al bestaat, verhoog de quantity
            $inventory->increment('quantity', $validated['quantity']);
            $message = 'Aantal verhoogd met ' . $validated['quantity'];
        } else {
            // Anders maak een nieuw inventory item aan
            Inventory::create([
                'user_id' => $validated['user_id'],
                'item_id' => $validated['item_id'],
                'quantity' => $validated['quantity'],
            ]);
            $message = 'Item succesvol toegekend';
        }

        return redirect()->route('admin.assign-item.index')
            ->with('success', $message);
    }

    /**
     * Verwijder een item uit een gebruiker zijn inventory (optioneel)
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.assign-item.index')
            ->with('success', 'Item verwijderd uit inventaris.');
    }

    /**
     * Pas de quantity van een item aan (optioneel)
     */
    public function updateQuantity(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);

        if ($validated['quantity'] == 0) {
            $inventory->delete();
            $message = 'Item verwijderd uit inventaris.';
        } else {
            $inventory->update(['quantity' => $validated['quantity']]);
            $message = 'Aantal bijgewerkt naar ' . $validated['quantity'];
        }

        return redirect()->route('admin.assign-item.index')
            ->with('success', $message);
    }
}
