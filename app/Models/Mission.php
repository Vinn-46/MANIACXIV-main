<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{
    use HasFactory;

    protected $table = 'missions';

    public function relics() : HasMany {
        return $this->hasMany(RelicMission::class, 'mission_id', 'id');
    }

    public function success() : HasMany {
        return $this->hasMany(Success::class, 'mission_id');
    }
}
