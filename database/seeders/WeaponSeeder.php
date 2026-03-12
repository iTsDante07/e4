<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class WeaponSeeder extends Seeder
{
    public function run(): void
    {
        $weapons = [
            [
                'name' => 'Zwaard van de Dageraad',
                'description' => 'Een zwaard dat licht uitstraalt en duisternis verdrijft.',
                'type' => 'wapen',
                'rarity' => 'episch',
                'required_level' => 35,
                'power' => 75,
                'speed' => 65,
                'durability' => 80,
                'magic' => 70,
            ],
            [
                'name' => 'Hammer van de Titan',
                'description' => 'Een enorme hamer die de grond laat trillen bij impact.',
                'type' => 'wapen',
                'rarity' => 'legendarisch',
                'required_level' => 55,
                'power' => 98,
                'speed' => 20,
                'durability' => 95,
                'magic' => 30,
            ],
            [
                'name' => 'Dolk van de Schaduw',
                'description' => 'Een dolk die bijna onzichtbaar is in het donker.',
                'type' => 'wapen',
                'rarity' => 'zeldzaam',
                'required_level' => 20,
                'power' => 40,
                'speed' => 95,
                'durability' => 35,
                'magic' => 45,
            ],
            [
                'name' => 'Staf van de Elementen',
                'description' => 'Een staf die alle elementen kan oproepen.',
                'type' => 'wapen',
                'rarity' => 'episch',
                'required_level' => 40,
                'power' => 60,
                'speed' => 50,
                'durability' => 70,
                'magic' => 95,
            ],
        ];

        foreach ($weapons as $weapon) {
            Item::create($weapon);
        }

        $this->command->info('Extra wapens zijn aangemaakt!');
    }
}
