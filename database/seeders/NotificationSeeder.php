<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trade;
use App\Notifications\TradeProposed;
use App\Notifications\TradeAccepted;
use App\Notifications\TradeDeclined;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'player')->get();
        $trades = Trade::with(['sender', 'receiver'])->get();

        foreach ($trades as $trade) {
            // Notificatie voor ontvanger over nieuw voorstel
            if ($trade->status == 'pending' && $trade->receiver) {
                $trade->receiver->notify(new TradeProposed($trade));
                $this->command->info('Notificatie aangemaakt voor ' . $trade->receiver->name . ' over trade #' . $trade->id);
            }

            // Notificatie voor verzender over acceptatie/weigering
            if ($trade->status == 'accepted' && $trade->sender) {
                $trade->sender->notify(new TradeAccepted($trade));
                $this->command->info('Acceptatie notificatie aangemaakt voor ' . $trade->sender->name);
            } elseif ($trade->status == 'declined' && $trade->sender) {
                $trade->sender->notify(new TradeDeclined($trade));
                $this->command->info('Weigering notificatie aangemaakt voor ' . $trade->sender->name);
            }
        }

        // Extra willekeurige notificaties voor testdoeleinden (zorg dat ze uniek zijn)
        foreach ($users as $user) {
            for ($i = 0; $i < rand(0, 2); $i++) {
                $randomUser = $users->where('id', '!=', $user->id)->random();

                $fakeTrade = new \stdClass();
                $fakeTrade->id = rand(1000, 9999);
                $fakeTrade->sender_id = $randomUser->id;
                $fakeTrade->sender = $randomUser;
                $fakeTrade->receiver_id = $user->id;
                $fakeTrade->receiver = $user;

                $user->notify(new TradeProposed($fakeTrade));
            }
        }

        $this->command->info('Notificaties zijn aangemaakt!');
    }
}
