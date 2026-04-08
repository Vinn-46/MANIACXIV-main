<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $table = 'markets';

    protected $fillable = [
        'player_id',
        'relic_id',
        'qty',
        'tears',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function relic()
    {
        return $this->belongsTo(Relic::class);
    }
}
