<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TradeAccepted extends Notification
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
            'accepted_by_id' => $this->trade->receiver_id ?? $this->trade->receiver->id ?? null,
            'accepted_by' => $this->trade->receiver->name ?? 'Iemand',
            'message' => 'Je handelsvoorstel #' . $this->trade->id . ' is geaccepteerd door ' . ($this->trade->receiver->name ?? 'Iemand'),
            'type' => 'trade_accepted',
            'created_at' => now()->toDateTimeString()
        ];
    }
}
