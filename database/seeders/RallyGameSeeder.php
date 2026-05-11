<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RallyGame;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class RallyGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rallyGames = [
            'single' => [
                'Scrab the Rubble' => 'michael',
                'Trail Fixer' => 'aldo',
                'Flow Reconstruction' => 'helena',
                'Remember the Map' => 'joriel',
                'Sheriff\'s Directive' => 'nathan',
                'Clearing Colors' => 'elis',
                'Decision Rush' => 'cecilia',
                'What the Hex?' => 'ferry',
            ],
            'battle' => [
                'Which is Better?' => 'icel',
                'Duel Shoot Out' => 'lionell',
                'Lorem Ipsum' => 'lapod',
                'Shape with Path' => 'nana',
            ],
            'inferno' => [
                'Match or Burn' => 'valent',
                'Noise Cancellation' => 'maritzka',
                'Catch the Bandit' => 'cenneth',
                'Your Personal Assistant' => 'jannice',
            ],
        ];

        $password = Hash::make('PenposRallyManiac!123');

        foreach ($rallyGames as $type => $games) {
            foreach ($games as $name => $keeperName) {
                $user = User::create([
                    'username' => "penpos_{$keeperName}",
                    'password' => $password,
                    'role' => 'penpos',
                ]);

                RallyGame::create([
                    'name' => $name,
                    'user_id' => $user->id,
                    'type' => $type,
                ]);
            }
        }
    }
}
