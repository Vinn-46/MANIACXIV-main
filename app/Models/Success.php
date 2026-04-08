<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Success extends Model
{
    use HasFactory;

    protected $table = 'successes';

    protected $fillable = [
        'player_id',
        'mission_id',
        'is_success'
    ];
}
