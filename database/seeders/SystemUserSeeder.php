<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Team, Player};
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete old SYSTEM user and related data if exists
        $userOld = User::where('username', 'SYSTEM')->first();

        if ($userOld) {
            // Find and delete inventory related to the player of the SYSTEM team
            $playerOld = Player::whereHas('team', fn($q) => $q->where('name', 'SYSTEM'))->first();
            if ($playerOld) {
                $playerOld->delete();
            }

            // Delete the team
            $teamOld = Team::where('name', 'SYSTEM')->first();
            if ($teamOld) {
                $teamOld->delete();
            }

            // Delete the user
            $userOld->delete();
        }

        // Create new SYSTEM user
        $user = User::create([
            'username' => 'SYSTEM',
            'password' => Hash::make('SystemManiac@2025'),
            'role'     => 'participant',
        ]);

        // Create new SYSTEM team
        $team = Team::create([
            'user_id'        => $user->id,
            'name'           => 'SYSTEM',
            'school_name'    => 'SYSTEM',
            'school_address' => 'SYSTEM',
            'school_number'  => '000000000',
            'status'         => 'verified',
        ]);

        // Create new SYSTEM player
        $player = Player::create([
            'team_id' => $team->id,
            'points'   => 999999999,
        ]);

        // Removed relic and inventory seeding
    }
}
