<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Wapens
            [
                'name' => 'Zwaard van de Draak',
                'description' => 'Een legendarisch zwaard dat gloeit met drakenvuur. Gesmeed in het hart van een vulkaan.',
                'type' => 'wapen',
                'rarity' => 'legendarisch',
                'required_level' => 50,
                'power' => 95,
                'speed' => 70,
                'durability' => 85,
                'magic' => 60,
            ],
            [
                'name' => 'Heldenzwaard',
                'description' => 'Een betrouwbaar zwaard voor beginnende avonturiers. Goed gebalanceerd en duurzaam.',
                'type' => 'wapen',
                'rarity' => 'gewoon',
                'required_level' => 1,
                'power' => 25,
                'speed' => 20,
                'durability' => 40,
                'magic' => 0,
            ],
            [
                'name' => 'Boog van de Wind',
                'description' => 'Een elegante boog die pijlen met de snelheid van de wind afschiet.',
                'type' => 'wapen',
                'rarity' => 'zeldzaam',
                'required_level' => 15,
                'power' => 45,
                'speed' => 90,
                'durability' => 30,
                'magic' => 20,
            ],
            [
                'name' => 'Demonendoder',
                'description' => 'Een tweehander die speciaal is ontworpen om demonen te verslaan.',
                'type' => 'wapen',
                'rarity' => 'episch',
                'required_level' => 35,
                'power' => 80,
                'speed' => 40,
                'durability' => 70,
                'magic' => 50,
            ],

            // Pantsers
            [
                'name' => 'Harnas van de IJsheer',
                'description' => 'Pantser gemaakt van eeuwig ijs dat beschermt tegen vuur en vorst.',
                'type' => 'pantser',
                'rarity' => 'episch',
                'required_level' => 40,
                'power' => 40,
                'speed' => 30,
                'durability' => 95,
                'magic' => 80,
            ],
            [
                'name' => 'Leren Vest',
                'description' => 'Een eenvoudig leren vest dat basisbescherming biedt.',
                'type' => 'pantser',
                'rarity' => 'gewoon',
                'required_level' => 1,
                'power' => 5,
                'speed' => 10,
                'durability' => 30,
                'magic' => 0,
            ],
            [
                'name' => 'Magiërsmantel',
                'description' => 'Een mantel geweven met magische draden die spreuken versterkt.',
                'type' => 'pantser',
                'rarity' => 'zeldzaam',
                'required_level' => 15,
                'power' => 10,
                'speed' => 40,
                'durability' => 30,
                'magic' => 75,
            ],
            [
                'name' => 'Pantser van de Onoverwinnelijke',
                'description' => 'Een legendarisch pantser dat de drager bijna onkwetsbaar maakt.',
                'type' => 'pantser',
                'rarity' => 'legendarisch',
                'required_level' => 60,
                'power' => 30,
                'speed' => 20,
                'durability' => 100,
                'magic' => 90,
            ],

            // Accessoires
            [
                'name' => 'Ring van Kracht',
                'description' => 'Een eenvoudige ring maar gevuld met oeroude kracht.',
                'type' => 'accessoire',
                'rarity' => 'zeldzaam',
                'required_level' => 20,
                'power' => 50,
                'speed' => 50,
                'durability' => 100,
                'magic' => 90,
            ],
            [
                'name' => 'Amulet van Genezing',
                'description' => 'Een amulet dat langzaam gezondheid herstelt tijdens gevechten.',
                'type' => 'accessoire',
                'rarity' => 'episch',
                'required_level' => 30,
                'power' => 20,
                'speed' => 30,
                'durability' => 80,
                'magic' => 95,
            ],
            [
                'name' => 'Ring van Versnelling',
                'description' => 'Een ring die de drager sneller laat bewegen en aanvallen.',
                'type' => 'accessoire',
                'rarity' => 'zeldzaam',
                'required_level' => 15,
                'power' => 10,
                'speed' => 95,
                'durability' => 60,
                'magic' => 40,
            ],
            [
                'name' => 'Drakenoog',
                'description' => 'Een zeldzame edelsteen die magische krachten versterkt.',
                'type' => 'accessoire',
                'rarity' => 'legendarisch',
                'required_level' => 45,
                'power' => 40,
                'speed' => 40,
                'durability' => 90,
                'magic' => 100,
            ],

            // Overige items
            [
                'name' => 'Gezondheidsdrankje',
                'description' => 'Herstelt 50 gezondheidspunten bij gebruik.',
                'type' => 'overig',
                'rarity' => 'gewoon',
                'required_level' => 1,
                'power' => 0,
                'speed' => 0,
                'durability' => 1,
                'magic' => 50,
            ],
            [
                'name' => 'Mana Drankje',
                'description' => 'Herstelt 30 mana punten bij gebruik.',
                'type' => 'overig',
                'rarity' => 'gewoon',
                'required_level' => 5,
                'power' => 0,
                'speed' => 0,
                'durability' => 1,
                'magic' => 70,
            ],
            [
                'name' => 'Teleportatie Steen',
                'description' => 'Een steen die de gebruiker naar een bekende locatie teleporteert.',
                'type' => 'overig',
                'rarity' => 'zeldzaam',
                'required_level' => 25,
                'power' => 0,
                'speed' => 100,
                'durability' => 5,
                'magic' => 80,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }

        $this->command->info(count($items) . ' items zijn aangemaakt!');
    }
}
