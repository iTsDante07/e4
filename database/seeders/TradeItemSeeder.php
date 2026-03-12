<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trade;
use App\Models\TradeOfferedItem;
use App\Models\TradeRequestedItem;
use App\Models\Item;

class TradeItemSeeder extends Seeder
{
    public function run(): void
    {
        $trades = Trade::all();
        $items = Item::all();

        foreach ($trades as $trade) {
            // Voeg aangeboden items toe (1-3 items)
            $offeredCount = rand(1, 3);
            $offeredItems = $items->random(min($offeredCount, $items->count()));

            foreach ($offeredItems as $item) {
                TradeOfferedItem::create([
                    'trade_id' => $trade->id,
                    'item_id' => $item->id,
                    'quantity' => rand(1, 2),
                ]);
            }

            // Voeg gevraagde items toe (0-2 items)
            $requestedCount = rand(0, 2);
            if ($requestedCount > 0) {
                $requestedItems = $items->whereNotIn('id', $offeredItems->pluck('id'))->random(min($requestedCount, $items->count()));

                foreach ($requestedItems as $item) {
                    TradeRequestedItem::create([
                        'trade_id' => $trade->id,
                        'item_id' => $item->id,
                        'quantity' => rand(1, 2),
                    ]);
                }
            }
        }

        $this->command->info('Items toegevoegd aan handelsverzoeken!');
    }
}
