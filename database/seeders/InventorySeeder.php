<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Item;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'player')->get();
        $items = Item::all();

        foreach ($users as $user) {
            // Geef elke speler een aantal willekeurige items
            $numberOfItems = rand(3, 8);
            $randomItems = $items->random($numberOfItems);

            foreach ($randomItems as $item) {
                Inventory::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'quantity' => rand(1, 3),
                ]);
            }
        }

        // Specifieke items voor bepaalde gebruikers (voor testdoeleinden)
        $john = User::where('email', 'john@example.com')->first();
        $dragonSword = Item::where('name', 'Zwaard van de Draak')->first();
        $healthPotion = Item::where('name', 'Gezondheidsdrankje')->first();

        if ($john && $dragonSword) {
            Inventory::create([
                'user_id' => $john->id,
                'item_id' => $dragonSword->id,
                'quantity' => 1,
            ]);
        }

        if ($john && $healthPotion) {
            Inventory::create([
                'user_id' => $john->id,
                'item_id' => $healthPotion->id,
                'quantity' => 5,
            ]);
        }

        $this->command->info('Inventarissen zijn gevuld!');
    }
}
