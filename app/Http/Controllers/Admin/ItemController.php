<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(15);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:wapen,pantser,accessoire,overig',
            'rarity' => 'required|in:gewoon,zeldzaam,episch,legendarisch',
            'required_level' => 'required|integer|min:1|max:100',
            'power' => 'required|integer|min:0|max:100',
            'speed' => 'required|integer|min:0|max:100',
            'durability' => 'required|integer|min:0|max:100',
            'magic' => 'required|integer|min:0|max:100',
        ]);

        Item::create($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item succesvol aangemaakt.');
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:wapen,pantser,accessoire,overig',
            'rarity' => 'required|in:gewoon,zeldzaam,episch,legendarisch',
            'required_level' => 'required|integer|min:1|max:100',
            'power' => 'required|integer|min:0|max:100',
            'speed' => 'required|integer|min:0|max:100',
            'durability' => 'required|integer|min:0|max:100',
            'magic' => 'required|integer|min:0|max:100',
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item succesvol bijgewerkt.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Item succesvol verwijderd.');
    }
}
