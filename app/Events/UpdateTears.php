<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTears implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playerId;

    public $tears;

    public function __construct($playerId)
    {
        $this->playerId = $playerId;
        $player = Player::find($playerId);

        $this->tears = $player->tears;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('update-tears.' . $this->playerId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'player_id' => $this->playerId,
            'tears' => $this->tears,
        ];
    }

    public function broadcastAs(): string
    {
        return 'UpdateTears';
    }
}
