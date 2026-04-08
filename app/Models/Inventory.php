<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventorys';
    
    protected $fillable = [
        'player_id',
        'relic_id',
        'qty',
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
