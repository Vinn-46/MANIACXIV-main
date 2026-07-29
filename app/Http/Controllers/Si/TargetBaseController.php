<?php

namespace App\Http\Controllers\Si;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Player;
use App\Models\TargetBase;
use App\Models\PlayerTargetBase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TargetBaseController extends Controller
{
    // Damage matrix based on weapon level
    const DAMAGE_MAP = [
        1 => 5,
        2 => 10,
        3 => 15
    ];

    public function index()
    {
        $players = Player::select('teams.name as team_name', 'players.*')
                    ->join('teams', 'teams.id', '=', 'players.team_id')
                    ->get();
        return view('si.target_base.index', compact('players'));
    }

    public function playerData(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id'
        ]);

        $playerId = $request->player_id;
        $player = Player::findOrFail($playerId);

        // Ensure player has base targets initialized
        $basesCount = TargetBase::count();
        $playerBasesCount = PlayerTargetBase::where('player_id', $playerId)->count();

        if ($playerBasesCount < $basesCount) {
            $allBases = TargetBase::all();
            foreach ($allBases as $base) {
                // Only create if not exists
                PlayerTargetBase::firstOrCreate(
                    [
                        'player_id' => $playerId,
                        'target_base_id' => $base->id
                    ],
                    [
                        'current_hp' => $base->max_hp,
                        'is_destroyed' => false
                    ]
                );
            }
        }

        $playerBases = PlayerTargetBase::with('targetBase')
                        ->where('player_id', $playerId)
                        ->get()
                        ->map(function($pb) {
                            return [
                                'id' => $pb->id,
                                'target_base_id' => $pb->target_base_id,
                                'type' => $pb->targetBase->type,
                                'current_hp' => $pb->current_hp,
                                'max_hp' => $pb->targetBase->max_hp,
                                'point_reward' => $pb->targetBase->point_reward,
                                'is_destroyed' => $pb->is_destroyed
                            ];
                        });

        return response()->json([
            'peluru' => $player->peluru,
            'weapon_level' => $player->weapon_level,
            'bases' => $playerBases
        ]);
    }

    public function attack(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'player_target_base_id' => 'required|exists:player_target_bases,id',
            'jumlah_tembakan' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $player = Player::lockForUpdate()->findOrFail($request->player_id);
            $pb = PlayerTargetBase::with('targetBase')
                    ->where('player_id', $player->id)
                    ->where('id', $request->player_target_base_id)
                    ->lockForUpdate()
                    ->firstOrFail();

            $jumlah = $request->jumlah_tembakan;

            if ($player->peluru < $jumlah) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => "Peluru tidak cukup! (Dibutuhkan: {$jumlah}, Dimiliki: {$player->peluru})"]);
            }

            if ($pb->is_destroyed) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Target sudah hancur!']);
            }


            // Calculate total damage
            $damagePerShot = self::DAMAGE_MAP[$player->weapon_level] ?? 5;

            // Calculate how many shots are actually needed to destroy the target
            $shotsNeeded = (int) ceil($pb->current_hp / $damagePerShot);
            $actualShotsUsed = min($jumlah, $shotsNeeded);
            $excessBullets = $jumlah - $actualShotsUsed;

            // Deduct only the bullets actually used
            $player->peluru -= $actualShotsUsed;
            $player->save();

            $totalDamage = $damagePerShot * $actualShotsUsed;

            $oldHp = $pb->current_hp;
            // Apply damage
            $pb->current_hp -= $totalDamage;

            $msg = "Berhasil menembak target {$actualShotsUsed} kali! (-{$totalDamage} HP)";
            if ($excessBullets > 0) {
                $msg .= "<br>{$excessBullets} peluru dikembalikan ke stok karena target hanya butuh {$actualShotsUsed} tembakan.";
            }

            $rewarded = 0;
            $bonus = 0;

            if ($pb->current_hp <= 0) {
                $pb->current_hp = 0;
                $pb->is_destroyed = true;
                $pb->destroyed_at = Carbon::now();

                $rewarded = $pb->targetBase->point_reward;
                $player->game_besar_points += $rewarded;

                $msg = "Target hancur! Tim mendapatkan {$rewarded} Poin Game Besar.";
                if ($excessBullets > 0) {
                    $msg .= "<br>{$excessBullets} peluru dikembalikan ke stok karena target hanya butuh {$actualShotsUsed} tembakan.";
                }

                // Hitung logika Bonus Poin "Balapan Kecepatan" per Kategori (Type)
                $type = $pb->targetBase->type;
                $targetIdsOfType = TargetBase::where('type', $type)->pluck('id')->toArray();

                // Cek sisa target bertipe sama untuk player ini
                // Gunakan != $pb->id karena $pb belum di-save ke database pada baris ini
                $remainingOfThisType = PlayerTargetBase::where('player_id', $player->id)
                                        ->whereIn('target_base_id', $targetIdsOfType)
                                        ->where('id', '!=', $pb->id)
                                        ->where('is_destroyed', false)
                                        ->count();

                if ($remainingOfThisType == 0) {
                    // Cari berapa banyak player LAIN yang sudah menghancurkan seluruh target bertipe ini
                    $otherPlayersCompleted = PlayerTargetBase::whereIn('target_base_id', $targetIdsOfType)
                                ->where('is_destroyed', true)
                                ->where('player_id', '!=', $player->id)
                                ->select('player_id')
                                ->groupBy('player_id')
                                ->havingRaw('COUNT(id) = ?', [count($targetIdsOfType)])
                                ->get()
                                ->count();

                    $rank = $otherPlayersCompleted + 1;
                    $bonus = 21 - $rank;
                    if ($bonus < 1) $bonus = 1; // Sesuai aturan: tim ke-20 mendapat 1 poin

                    $player->bonus_points += $bonus;

                    $msg .= "<br><br>Kategori {$type} hangus! Tim mendapat bonus {$bonus} poin.";
                }

                $player->save();
            }

            $pb->save();

            $msgBullets = ($actualShotsUsed != $jumlah) ? "$actualShotsUsed/$jumlah" : $jumlah;
            $msgHp = "$oldHp - $totalDamage → <strong>{$pb->current_hp}</strong>";

            $msgPoints = "";
            if ($rewarded > 0) {
                $msgPoints = " | Poin: <strong>+$rewarded</strong>";
                if ($bonus > 0) {
                    $msgPoints .= ", <strong>++$bonus</strong>";
                }
            }

            Log::create([
                'player_id' => $player->id,
                'desc' => "[Target Base] Menembak base <strong>{$pb->id}</strong> (<strong>{$pb->targetBase->type}</strong>) dengan <strong>$msgBullets</strong> peluru (HP: $msgHp$msgPoints)",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $msg,
                'current_hp' => $pb->current_hp,
                'is_destroyed' => $pb->is_destroyed,
                'new_peluru' => $player->peluru,
                'damage_dealt' => $totalDamage
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }
}
