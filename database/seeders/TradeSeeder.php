<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trade;
use App\Models\User;

class TradeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'player')->get();

        if ($users->count() < 2) {
            $this->command->warn('Niet genoeg spelers voor handelsverzoeken.');
            return;
        }

        // Maak een aantal handelsverzoeken aan
        for ($i = 0; $i < 5; $i++) {
            $sender = $users->random();
            $receiver = $users->where('id', '!=', $sender->id)->random();

            $statuses = ['pending', 'accepted', 'declined'];
            $status = $statuses[array_rand($statuses)];

            $trade = Trade::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'status' => $status,
                'created_at' => now()->subDays(rand(1, 10)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);

            $this->command->info("Handelsverzoek #{$trade->id} aangemaakt van {$sender->name} naar {$receiver->name} met status: {$status}");
        }
    }
}
