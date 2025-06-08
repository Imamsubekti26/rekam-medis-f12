<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(
        public string $message,
        public string $type = 'info',
        public ?string $url = null
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('new-appointment'),
        ];
    }

    public function broadcastAs()
    {
        return 'notification.created'; // Nama event lebih spesifik
    }

    // Tambahkan data yang akan dikirim
    public function broadcastWith()
    {        
        return [
            'message' => $this->message,
            'time' => now()->format('H:i:s')
        ];
    }
}
