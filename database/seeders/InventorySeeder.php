<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = Player::all();
        
        // CLEAR PLAYER INVENTORY AND RESET AUTO INCREMENT
        // Inventory::truncate();

        $relicIds = [1, 2, 3];
        // foreach ($players as $player) {
        //     foreach ($relicIds as $relicId) {
        //         $player->inventory()->create([
        //             'relic_id' => $relicId,
        //             'qty' => 0,
        //         ]);
        //     }
        // }

        foreach ($players as $player) {
            if (!$player->inventory()->exists()) {
                foreach ($relicIds as $relicId) {
                    $player->inventory()->create([
                        'relic_id' => $relicId,
                        'qty' => 0,
                    ]);
                }
            }
        }
    }
}
