<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inventory; // <- Deze import was verkeerd of ontbrak
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:player,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol aangemaakt.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:player,admin',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy(User $user)
    {
        // Voorkom dat je jezelf verwijdert
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Je kunt je eigen account niet verwijderen.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol verwijderd.');
    }

    public function inventory(User $user)
    {
        // Haal alle items van deze gebruiker op met bijbehorende item details
        $inventory = Inventory::where('user_id', $user->id)
            ->with('item')
            ->get();

        // Groepeer items per type voor een mooi overzicht
        $groupedItems = $inventory->groupBy(function($item) {
            return $item->item->type;
        });

        // Bereken totalen
        $totalItems = $inventory->sum('quantity');
        $uniqueItems = $inventory->count();

        return view('admin.users.inventory', compact('user', 'inventory', 'groupedItems', 'totalItems', 'uniqueItems'));
    }
}
