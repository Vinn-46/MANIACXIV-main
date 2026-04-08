<?php

namespace App\Events;

use App\Models\Market;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateMarket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $marketDatas;
    public $amountRelicInMarket;

    public function __construct()
    {
        $markets = Market::with(['relic' => function ($query) {
            $query->select('id', 'nama'); 
        }])->where('qty', '>', 0)->latest()->get(['id', 'relic_id', 'player_id', 'qty', 'tears']);

        $this->marketDatas = $markets->map(function ($market) {
            return [
                'id' => $market->id,
                'relic_id' => $market->relic_id,
                'player_id' => $market->player_id,
                'qty' => $market->qty,
                'tears' => $market->tears,
                'relic_name' => $market->relic ? $market->relic->nama : 'Unknown Relic'
            ];
        });;

        $this->amountRelicInMarket = [
            'red' => $markets->where('relic_id', 1)->sum('qty'),
            'purple' => $markets->where('relic_id', 2)->sum('qty'),
            'blue' => $markets->where('relic_id', 3)->sum('qty'),
        ];
    }
    
    public function broadcastOn(): array
    {
        return [
            new Channel('update-market'),
        ];
    }

    public function broadcastWith(): array
    {
         return [
            'markets' => $this->marketDatas,
            'amountRelicInMarket' => $this->amountRelicInMarket,
        ];
    }
}
