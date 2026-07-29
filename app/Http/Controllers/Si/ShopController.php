<?php

namespace App\Http\Controllers\Si;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $players = Player::select('teams.name as team_name', 'players.*')
                    ->join('teams', 'teams.id', '=', 'players.team_id')
                    ->get();

        return view('si.shop.index', compact('players'));
    }

    public function getPlayerDetails(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id'
        ]);

        $player = Player::findOrFail($request->player_id);

        return response()->json([
            'honor' => $player->honor,
            'peluru' => $player->peluru,
            'weapon_level' => $player->weapon_level
        ]);
    }

    public function buyPeluru(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'amount' => 'required|integer|min:1'
        ]);

        $amount = (int) $request->amount;
        $cost = $amount * 100;

        try {
            DB::beginTransaction();

            $player = Player::findOrFail($request->player_id);

            if ($player->honor < $cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Honor tidak mencukupi untuk membeli peluru.'
                ], 400);
            }

            $oldHonor = $player->honor;
            $player->honor -= $cost;
            $player->peluru += $amount;
            $player->save();

            Log::create([
                'player_id' => $player->id,
                'desc' => "[Shop] Membeli <strong>$amount</strong> peluru (Honor: $oldHonor - $cost → <strong>{$player->honor}</strong>)",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil membelikan $amount peluru seharga $cost Honor.",
                'new_honor' => $player->honor,
                'new_peluru' => $player->peluru
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function upgradeWeapon(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id'
        ]);

        try {
            DB::beginTransaction();

            $player = Player::findOrFail($request->player_id);
            $currentHonor = $player->honor;
            $currentLevel = $player->weapon_level;
            $cost = 0;

            if ($currentLevel == 1) {
                $cost = 300;
            } elseif ($currentLevel == 2) {
                $cost = 600;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Senjata tim ini sudah mencapai level maksimal.'
                ], 400);
            }

            if ($player->honor < $cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Honor tidak mencukupi untuk melakukan upgrade senjata.'
                ], 400);
            }

            $player->honor -= $cost;
            $player->weapon_level += 1;
            $player->save();

            Log::create([
                'player_id' => $player->id,
                'desc' => "[Shop] Melakukan upgrade senjata ke level <strong>{$player->weapon_level}</strong> (Honor: {$currentHonor} - $cost → {$player->honor})",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil upgrade senjata ke level {$player->weapon_level}.",
                'new_honor' => $player->honor,
                'new_weapon_level' => $player->weapon_level
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
