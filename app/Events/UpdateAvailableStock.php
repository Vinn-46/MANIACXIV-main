<?php

namespace App\Events;

use Carbon\Carbon;
use App\Models\GameBesarSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateAvailableStock implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $availableStock;

    public function __construct()
    {
        $gameBesarSession = GameBesarSession::where('open', '<=', Carbon::now())
                    ->where('close', '>=', Carbon::now())
                    ->first();
        $session = $gameBesarSession->id ?? 0;

        $this->availableStock = [
            'id' => $session,
            'red_relic_stock' => $gameBesarSession->red_relic_stock ?? 0,
            'blue_relic_stock' => $gameBesarSession->blue_relic_stock ?? 0,
            'purple_relic_stock' => $gameBesarSession->purple_relic_stock ?? 0
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('update-available-stock'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'availableStock' => $this->availableStock
        ];
    }
}
