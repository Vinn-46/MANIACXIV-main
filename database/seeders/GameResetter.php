<?php

namespace Database\Seeders;

use App\Models\{
    Score,
    Player,
    Log,
};

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GameResetter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Score::query()->delete();
        DB::statement('ALTER TABLE scores AUTO_INCREMENT = 1');

        Log::truncate();



        // Reset player data
        $participants = Player::whereHas('team', fn($q) => $q->where('name', '!=', 'SYSTEM'))->get();
        foreach ($participants as $player) {
            $player->update(['points' => 0]);
        }

        // Reset system player
        $system = Player::whereHas('team', fn($q) => $q->where('name', 'SYSTEM'))->first();
        if ($system) {
            $system->update(['points' => 1000000]);
        }
    }
}
