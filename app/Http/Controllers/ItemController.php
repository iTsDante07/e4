<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }
        if ($request->filled('min_level')) {
            $query->where('required_level', '>=', $request->min_level);
        }
        if ($request->filled('max_level')) {
            $query->where('required_level', '<=', $request->max_level);
        }
        // Voeg filters toe voor stats indien gewenst

        $items = $query->paginate(12)->withQueryString();

        $types = Item::select('type')->distinct()->pluck('type');
        $rarities = Item::select('rarity')->distinct()->pluck('rarity');

        return view('items.index', compact('items', 'types', 'rarities'));
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}
