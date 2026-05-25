<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TargetBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'max_hp',
        'point_reward',
    ];

    public function playerTargetBases() : HasMany {
        return $this->hasMany(PlayerTargetBase::class, 'target_base_id');
    }
}
