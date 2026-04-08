<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // FOR OFFICIAL PLAYER CASE, DON'T FORGET:
        // 1) FinalPlayerSeeder (DatabaseSeeder)
        // 2) Uncomment on SIController
        // 3) Set APP_DEBUG to false in .env
        // 4) Uncomment on SuperSI PlayerController

        // GAME BESEAR RESETTER
        $this->call(GameResetter::class);

        // USER SEEDER WITH FAKE PASSWORD (for testing, password is "1234567890")
        // $this->call(UserSeederFakePassword::class);

        // $this->call(UserSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(TeamSeader::class);
        // $this->call(ParticipantSeeder::class);
        // $this->call(AcaraSeeder::class);

        // SIMUL & GLADI PLAYER SEEDER
        // $this->call(PlayerSimulSeeder::class);

        // FINAL PLAYER SEEDER
        // $this->call(FinalPlayerSeeder::class);

        // RELIC SEEDER (creates red, purple, and blue relic)
        // $this->call(RelicSeeder::class);

        // MISSION SEEDER (creates three mission with different requirements)
        // $this->call(MissionSeeder::class);

        // RELIC MISSION SEEDER (assigns relics for each mission)
        // $this->call(RelicMissionSeeder::class);

        // RALLY GAME SEEDER (creates rally games and assign penpos)
        // $this->call(RallyGameSeeder::class);
        
        // POINT SEEDER (creates point options for penpos)
        // $this->call(PointSeeder::class);
        
        // INVENTORY SEEDER (create inventory for each player, where qty is 0)
        // $this->call(InventorySeeder::class);

        // USER "SYSTEM" SEEDER (create user called "SYSTEM" for Game Besar)
        // $this->call(SystemUserSeeder::class);
    }
}
