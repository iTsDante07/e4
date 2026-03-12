<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

class AdminReportController extends Controller
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
            $data[] = ['type' => $type, 'aantal_spelers' => $count];
        }

        return view('admin.reports.item-type', compact('data'));
    }
}
