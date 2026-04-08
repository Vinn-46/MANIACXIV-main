<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GameBesarSession extends Model
{
    use HasFactory;

    protected $table = 'game_besar_sessions';

    protected $fillable = [
        'open',
        'close',
        'mission_id',
        'red_relic_stock',
        'purple_relic_stock',
        'blue_relic_stock',
    ];

    public function players() : BelongsToMany {
        return $this->belongsToMany(
            Player::class,
            'power_up',
            'session_id',
            'player_id'
        )
            ->withTimestamps();
    }

    public function mission() : HasOne {
        return $this->hasOne(Mission::class, 'id', 'mission_id');
    }
}
