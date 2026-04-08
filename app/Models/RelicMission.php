<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelicMission extends Model
{
    use HasFactory;

    protected $table = 'relic_missions';

    protected $fillable = [
        'mission_id',
        'relic_id',
        'qty',
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function relic()
    {
        return $this->belongsTo(Relic::class);
    }
}
