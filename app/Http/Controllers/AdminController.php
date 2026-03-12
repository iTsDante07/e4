<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Trade;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPlayers = User::where('role', 'player')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalItems = Item::count();
        $totalTrades = Trade::count();
        $pendingTrades = Trade::where('status', 'pending')->count();

        // Recente gebruikers
        $recentUsers = User::latest()->take(5)->get();

        // Meest voorkomende items
        $popularItems = Item::withCount('inventories')
            ->orderBy('inventories_count', 'desc')
            ->take(5)
            ->get();

        // Items per type
        $itemsByType = Item::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPlayers',
            'totalAdmins',
            'totalItems',
            'totalTrades',
            'pendingTrades',
            'recentUsers',
            'popularItems',
            'itemsByType'
        ));
    }
}
