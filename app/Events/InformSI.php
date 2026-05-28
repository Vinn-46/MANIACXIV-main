<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\RallyGame;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InformSI implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rallyGame;

    public function __construct($rallyGameId)
    {
        $this->rallyGame = RallyGame::findOrFail($rallyGameId);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('inform-si'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'rallyGame' => $this->rallyGame,
            'called_at' => now()->toDateTimeString(),
        ];
    }
}
