<?php

namespace Database\Seeders;

use App\Models\{
    GameBesarSession,
    MarketLog,
    RelicChosen,
    Success,
    Score,
    Player,
    Log,
    Market,
    Note
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
        // Truncate tables
        RelicChosen::query()->delete();
        DB::statement('ALTER TABLE relic_chosens AUTO_INCREMENT = 1');
        Score::query()->delete();
        DB::statement('ALTER TABLE scores AUTO_INCREMENT = 1');

        Note::truncate();
        MarketLog::truncate();
        Log::truncate();

        Market::query()->delete();
        DB::statement('ALTER TABLE markets AUTO_INCREMENT = 1');

        Success::truncate();
        GameBesarSession::truncate();

        // Reset player data
        $participants = Player::whereHas('team', fn($q) => $q->where('name', '!=', 'SYSTEM'))->get();
        foreach ($participants as $player) {
            $player->update(['tears' => 0]);
            $player->inventory()->update(['qty' => 0]);
        }

        // Reset system player
        $system = Player::whereHas('team', fn($q) => $q->where('name', 'SYSTEM'))->first();
        if ($system) {
            $system->update(['tears' => 1000000]);
            $system->inventory()->update(['qty' => 1000]);
        }
    }
}
