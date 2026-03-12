<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Toon het profiel van de ingelogde gebruiker
     */
    public function show()
    {
        $user = auth()->user();

        // Haal statistieken op
        $totalItems = $user->inventories()->sum('quantity');
        $uniqueItems = $user->inventories()->count();
        $sentTrades = $user->sentTrades()->count();
        $receivedTrades = $user->receivedTrades()->count();
        $pendingTrades = $user->receivedTrades()->where('status', 'pending')->count();

        return view('profile', compact(
            'user',
            'totalItems',
            'uniqueItems',
            'sentTrades',
            'receivedTrades',
            'pendingTrades'
        ));
    }

    /**
     * Toon het formulier om profiel te bewerken
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile-edit', compact('user'));
    }

    /**
     * Update het profiel
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profiel succesvol bijgewerkt!');
    }

    /**
     * Toon formulier om wachtwoord te wijzigen
     */
    public function passwordForm()
    {
        return view('password-change');
    }

    /**
     * Update het wachtwoord
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('profile')->with('success', 'Wachtwoord succesvol gewijzigd!');
    }
}
