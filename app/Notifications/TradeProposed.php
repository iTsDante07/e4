<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TradeProposed extends Notification
{
    use Queueable;

    protected $trade;

    public function __construct($trade)
    {
        $this->trade = $trade;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'trade_id' => $this->trade->id,
            'sender_id' => $this->trade->sender_id ?? $this->trade->sender->id ?? null,
            'sender_name' => $this->trade->sender->name ?? $this->trade->sender_name ?? 'Iemand',
            'message' => 'Je hebt een nieuw handelsvoorstel ontvangen van ' . ($this->trade->sender->name ?? $this->trade->sender_name ?? 'Iemand'),
            'type' => 'trade_proposed',
            'created_at' => now()->toDateTimeString()
        ];
    }
}
