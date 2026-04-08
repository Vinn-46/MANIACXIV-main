<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RallyGame;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RallyGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startPenposId = User::where('role', 'penpos')->first()->id;

        $singleRallyGameDatas = [
            "Guess the Shape",
            "Colour Box",
            "Remember and Shape",
            "Secret Picture",
            "Hopscotch", 
            "Blindbox",
            "Pitch it",
            "UI Recall",
        ];

        foreach ($singleRallyGameDatas as $single) {
            RallyGame::create([
                'name' => $single,
                'user_id' => $startPenposId,
                'type' => 'single'
            ]);
            $startPenposId++;
        }

        $battleRallyGames = [
            "Don't Touch the Color",
            "Search the Sound",
            "JengQuiz",
            "This is Your Time",
        ];

        foreach ($battleRallyGames as $battle) {
            RallyGame::create([
                'name' => $battle,
                'user_id' => $startPenposId,
                'type' => 'battle'  
            ]);
            $startPenposId++;
        }

        $hellRallyGames = [
            "UI Duplicate",
            "Colorsig",
            "PixPerfect",
            "Reshape It",
        ];
        
        foreach ($hellRallyGames as $hell) {
            RallyGame::create([
                'name' => $hell,
                'user_id' => $startPenposId,
                'type' => 'hel'
            ]);
            $startPenposId++;
        }
    }
}
