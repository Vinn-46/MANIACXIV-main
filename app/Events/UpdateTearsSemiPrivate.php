<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateTearsSemiPrivate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiverId;
    public $tears;

    public function __construct($receiverId)
    {
        $this->receiverId = $receiverId;
        $player = Player::find($receiverId);

        $this->tears = $player->tears;
    }
    
    public function broadcastOn(): array
    {
        return [
            new Channel('update-tears-semi-private'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'receiverId' => $this->receiverId,
            'tears' => $this->tears
        ];
    }
}
