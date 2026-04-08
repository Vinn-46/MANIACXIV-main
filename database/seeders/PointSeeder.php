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
        $pointDatas = [
            'single' => [
                'win' => [
                    'tears' => 100,
                    'relic_qty' => 1,
                ],
                'draw' => [
                    'tears' => 50,
                    'relic_qty' => 0,
                ],
                'lose' => [
                    'tears' => 0,
                    'relic_qty' => 0,
                ],
            ],
            'battle' => [
                'win' => [
                    'tears' => 200,
                    'relic_qty' => 2,
                ],
                'draw' => [
                    'tears' => 100,
                    'relic_qty' => 1,
                ],
                'lose' => [
                    'tears' => 0,
                    'relic_qty' => 0,
                ],
            ],
            'hel' => [
                'win' => [
                    'tears' => 200,
                    'relic_qty' => 3,
                ],
                'draw' => [
                    'tears' => 100,
                    'relic_qty' => 2,
                ],
                'lose' => [
                    'tears' => 0,
                    'relic_qty' => 0,
                ],
            ],
        ];

        foreach ($pointDatas as $type => $data) {
            foreach ($data as $condition => $value) {
                Point::create([
                    'type' => $type,
                    'condition' => $condition,
                    'point' => $value['tears'],
                    'relic_qty' => $value['relic_qty'],
                ]);
            }
        }
    }
}
