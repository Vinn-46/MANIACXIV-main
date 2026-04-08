<?php

namespace Database\Seeders;

use App\Models\Relic;
use App\Models\Mission;
use App\Models\RelicMission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RelicMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relics = Relic::all()->pluck('id', 'color');
        $relicMissionDatas = [
            'first' => [
                'mission_id' => 1,
                'relics' => [
                    [
                        'relic_id' => $relics['red'],
                        'qty' => 1,
                    ],
                    [
                        'relic_id' => $relics['purple'],
                        'qty' => 1,
                    ],
                    [
                        'relic_id' => $relics['blue'],
                        'qty' => 2,
                    ],
                ]
            ],

            'second' => [
                'mission_id' => 2,
                'relics' => [
                    [
                        'relic_id' => $relics['red'],
                        'qty' => 2,
                    ],
                    [
                        'relic_id' => $relics['purple'],
                        'qty' => 2,
                    ],
                    [
                        'relic_id' => $relics['blue'],
                        'qty' => 1,
                    ],
                ]
            ],

            'third' => [
                'mission_id' => 3,
                'relics' => [
                    [
                        'relic_id' => $relics['red'],
                        'qty' => 2,
                    ],
                    [
                        'relic_id' => $relics['purple'],
                        'qty' => 3,
                    ],
                    [
                        'relic_id' => $relics['blue'],
                        'qty' => 2,
                    ],
                ]
            ],
        ];

        foreach ($relicMissionDatas as $relicMissionData) { // First, Second, Third
            foreach ($relicMissionData['relics'] as $relic) { // Red, Purple, Blue
                RelicMission::create([
                    'mission_id' => $relicMissionData['mission_id'],
                    'relic_id' => $relic['relic_id'],
                    'qty' => $relic['qty'],
                ]);
            }
        }
    }
}
