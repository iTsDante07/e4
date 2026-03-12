<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ArmorSeeder extends Seeder
{
    public function run(): void
    {
        $armors = [
            [
                'name' => 'Schubbenpantser van de Draak',
                'description' => 'Pantser gemaakt van echte drakenschubben.',
                'type' => 'pantser',
                'rarity' => 'legendarisch',
                'required_level' => 60,
                'power' => 50,
                'speed' => 40,
                'durability' => 98,
                'magic' => 80,
            ],
            [
                'name' => 'Lichte Keten',
                'description' => 'Een lichte kettingharnas dat goede bescherming biedt zonder snelheid te verliezen.',
                'type' => 'pantser',
                'rarity' => 'zeldzaam',
                'required_level' => 20,
                'power' => 20,
                'speed' => 60,
                'durability' => 65,
                'magic' => 15,
            ],
            [
                'name' => 'Pantser van de Wreker',
                'description' => 'Een pantser dat schade reflecteert naar aanvallers.',
                'type' => 'pantser',
                'rarity' => 'episch',
                'required_level' => 45,
                'power' => 60,
                'speed' => 35,
                'durability' => 85,
                'magic' => 70,
            ],
        ];

        foreach ($armors as $armor) {
            Item::create($armor);
        }

        $this->command->info('Extra pantsers zijn aangemaakt!');
    }
}
