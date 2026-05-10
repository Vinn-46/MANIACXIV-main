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
                ],
                'draw' => [
                    'value' => 50,
                ],
                'lose' => [
                    'value' => 0,
                ],
            ],
            'battle' => [
                'win' => [
                    'value' => 200,
                ],
                'draw' => [
                    'value' => 100,
                ],
                'lose' => [
                    'value' => 0,
                ],
            ],
            'inferno' => [
                'win' => [
                    'value' => 300,
                ],
                'draw' => [
                    'value' => 100,
                ],
                'lose' => [
                    'value' => 0,
                ],
            ],
        ];

        foreach ($points as $type => $point) {
            foreach ($point as $condition => $data) {
                Point::create([
                    'type' => $type,
                    'condition' => $condition,
                    'value' => $data['value'],
                ]);
            }
        }
    }
}
