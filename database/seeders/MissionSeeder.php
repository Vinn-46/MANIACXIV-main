<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $missions = [
            [
                'id' => 1,
                'name' => 'FIRST - 1 Red, 1 Purple, 2 Blue',
                'point' => 20,
            ],
            [
                'id' => 2,
                'name' => 'SECOND - 2 Red, 2 Purple, 1 Blue',
                'point' => 30,
            ],
            [
                'id' => 3,
                'name' => 'THIRD - 2 Red, 3 Purple, 2 Blue',
                'point' => 50,
            ],
        ];

        foreach ($missions as $mission) {
            Mission::create($mission);
        }
    }
}
