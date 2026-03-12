<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class AccessorySeeder extends Seeder
{
    public function run(): void
    {
        $accessories = [
            [
                'name' => 'Ring van Onzichtbaarheid',
                'description' => 'Maakt de drager onzichtbaar voor vijanden.',
                'type' => 'accessoire',
                'rarity' => 'episch',
                'required_level' => 40,
                'power' => 20,
                'speed' => 30,
                'durability' => 70,
                'magic' => 95,
            ],
            [
                'name' => 'Amulet van Bescherming',
                'description' => 'Vermindert alle ontvangen schade met 20%.',
                'type' => 'accessoire',
                'rarity' => 'zeldzaam',
                'required_level' => 25,
                'power' => 10,
                'speed' => 10,
                'durability' => 90,
                'magic' => 80,
            ],
            [
                'name' => 'Ring van Fortuin',
                'description' => 'Verhoogt de kans op zeldzame vondsten.',
                'type' => 'accessoire',
                'rarity' => 'legendarisch',
                'required_level' => 50,
                'power' => 0,
                'speed' => 0,
                'durability' => 100,
                'magic' => 100,
            ],
        ];

        foreach ($accessories as $accessory) {
            Item::create($accessory);
        }

        $this->command->info('Extra accessoires zijn aangemaakt!');
    }
}
