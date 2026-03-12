<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function itemTypeReport()
    {
        $types = Item::select('type')
            ->distinct()
            ->get()
            ->pluck('type');

        $data = [];
        foreach ($types as $type) {
            $count = User::whereHas('inventories.item', function ($query) use ($type) {
                $query->where('type', $type);
            })->count();

            $totalItems = Item::where('type', $type)->count();
            $totalInCirculation = \DB::table('inventories')
                ->join('items', 'inventories.item_id', '=', 'items.id')
                ->where('items.type', $type)
                ->sum('inventories.quantity');

            $data[] = [
                'type' => $type,
                'aantal_spelers' => $count,
                'totaal_items' => $totalItems,
                'in_omloop' => $totalInCirculation,
            ];
        }

        return view('admin.reports.item-type', compact('data'));
    }
}
