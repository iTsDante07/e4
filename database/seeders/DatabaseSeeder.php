<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Eerst gebruikers aanmaken
            AdminUserSeeder::class,
            UserSeeder::class,

            // Dan items aanmaken
            ItemSeeder::class,
            WeaponSeeder::class,
            ArmorSeeder::class,
            AccessorySeeder::class,

            // Dan inventarissen vullen
            InventorySeeder::class,

            // Dan handelsverzoeken aanmaken
            TradeSeeder::class,
            TradeItemSeeder::class,

            // Tot slot notificaties
            NotificationSeeder::class,
        ]);
    }
}
