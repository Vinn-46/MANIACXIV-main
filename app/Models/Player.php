<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'points',
        'honor',
        'peluru',
        'weapon_level',
        'game_besar_points',
        'bonus_points',
    ];

    public function team() : BelongsTo {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function logs() : HasMany {
        return $this->hasMany(Log::class, 'player_id');
    }

    public function scores() : HasMany {
        return $this->hasMany(Score::class, 'player_id');
    }

    public function playerTargetBases() : HasMany {
        return $this->hasMany(PlayerTargetBase::class, 'player_id');
    }
}
