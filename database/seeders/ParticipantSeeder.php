<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();
        foreach ($teams as $team) {
            for ($cnt = 1; $cnt <= 3; $cnt++) {
                Participant::create([
                    'email' => $team->name . "_" . "$cnt@gmail.com",
                    'position' => ($cnt == 1) ? "leader" : "member",
                    'name' => $team->name . "_" . $cnt,
                    'phone_number' => '08123456789',
                    'student_photo' => '',
                    'team_id' => $team->id,
                    'alergi' => 'Friend Zone',
                ]);
            }
        }
    }
}
