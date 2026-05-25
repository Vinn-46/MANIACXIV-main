<?php

namespace Database\Seeders;

use App\Models\TargetBase;
use Illuminate\Database\Seeder;

class TargetBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 4 Small targets (Puncak)
        for ($i = 0; $i < 4; $i++) {
            TargetBase::create([
                'type' => 'small',
                'max_hp' => 10,
                'point_reward' => 5,
            ]);
        }

        // 3 Medium targets (Tengah)
        for ($i = 0; $i < 3; $i++) {
            TargetBase::create([
                'type' => 'medium',
                'max_hp' => 20,
                'point_reward' => 10,
            ]);
        }

        // 2 Large targets (Dasar)
        for ($i = 0; $i < 2; $i++) {
            TargetBase::create([
                'type' => 'large',
                'max_hp' => 50,
                'point_reward' => 30,
            ]);
        }
    }
}
