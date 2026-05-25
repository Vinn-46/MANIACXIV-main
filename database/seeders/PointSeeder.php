<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $points = [
            'single' => [
                'win' => [
                    'value' => 100,
                    'peluru_reward' => 2,
                    'honor_reward' => 100,
                ],
                'draw' => [
                    'value' => 50,
                    'peluru_reward' => 1,
                    'honor_reward' => 50,
                ],
                'lose' => [
                    'value' => 0,
                    'peluru_reward' => 0,
                    'honor_reward' => 0,
                ],
            ],
            'battle' => [
                'win' => [
                    'value' => 200,
                    'peluru_reward' => 4,
                    'honor_reward' => 200,
                ],
                'draw' => [
                    'value' => 100,
                    'peluru_reward' => 2,
                    'honor_reward' => 100,
                ],
                'lose' => [
                    'value' => 0,
                    'peluru_reward' => 1,
                    'honor_reward' => 0,
                ],
            ],
            'inferno' => [
                'win' => [
                    'value' => 300,
                    'peluru_reward' => 6,
                    'honor_reward' => 300,
                ],
                'draw' => [
                    'value' => 100,
                    'peluru_reward' => 3,
                    'honor_reward' => 150,
                ],
                'lose' => [
                    'value' => 0,
                    'peluru_reward' => 1,
                    'honor_reward' => 0,
                ],
            ],
        ];

        foreach ($points as $type => $point) {
            foreach ($point as $condition => $data) {
                Point::create([
                    'type' => $type,
                    'condition' => $condition,
                    'value' => $data['value'],
                    'peluru_reward' => $data['peluru_reward'],
                    'honor_reward' => $data['honor_reward'],
                ]);
            }
        }
    }
}
