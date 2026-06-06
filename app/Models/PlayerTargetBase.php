<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerTargetBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'target_base_id',
        'current_hp',
        'is_destroyed',
        'destroyed_at',
    ];

    protected $casts = [
        'is_destroyed' => 'boolean',
    ];

    public function player() : BelongsTo {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function targetBase() : BelongsTo {
        return $this->belongsTo(TargetBase::class, 'target_base_id');
    }
}
