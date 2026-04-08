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

    protected $table = 'players';

    protected $fillable = [
        'team_id',
        'tears',
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

    public function marketLogs() : HasMany {
        return $this->hasMany(MarketLog::class, 'player_id');
    }

    public function inventory() : HasMany {
        return $this->hasMany(Inventory::class, 'player_id');
    }

    public function markets() : HasManyThrough {
        return $this->hasManyThrough(Market::class, Inventory::class, 'player_id', 'player_id', 'id');
    }

    public function success() : HasOne {
        return $this->hasOne(Success::class, 'player_id');
    }

    public function successes()
    {
        return $this->hasMany(Success::class);
    }
}
