<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinalPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notAllowed = collect(range(1, 20))
        $teams = Team::whereNotIn('id', $notAllowed)
                        ->where('status', 'verified')
                        ->where('name', '!=', 'SYSTEM')
                        ->get();

        foreach ($teams as $team) {
            Player::create([
                'team_id' => $team->id,
            ]);
        }
    }
}
