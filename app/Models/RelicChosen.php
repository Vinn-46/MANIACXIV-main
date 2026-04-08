<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelicChosen extends Model
{
    use HasFactory;

    protected $table = 'relic_chosens';

    protected $fillable = [
        'score_id',
        'red_relic_qty',
        'blue_relic_qty',
        'purple_relic_qty'
    ];

    public function score()
    {
        return $this->belongsTo(Score::class);
    }
}
