<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'rally_game_id',
        'called_at',
        'resolved',
    ];

    public function rallyGame()
    {
        return $this->belongsTo(RallyGame::class);
    }
}
