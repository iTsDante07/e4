<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->inventories()->with('item');

        // Sorteren
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name':
                    $query->join('items', 'inventories.item_id', '=', 'items.id')
                          ->orderBy('items.name');
                    break;
                case 'type':
                    $query->join('items', 'inventories.item_id', '=', 'items.id')
                          ->orderBy('items.type');
                    break;
                case 'rarity':
                    $query->join('items', 'inventories.item_id', '=', 'items.id')
                          ->orderBy('items.rarity');
                    break;
                case 'quantity':
                    $query->orderBy('quantity', 'desc');
                    break;
            }
        }

        $inventory = $query->paginate(15);

        return view('inventory.index', compact('inventory'));
    }
}
