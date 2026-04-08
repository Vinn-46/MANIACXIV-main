<?php

namespace App\Http\Controllers\Si;

use Exception;
use App\Models\Market;
use App\Models\Player;
use App\Models\Success;
use App\Models\Inventory;
use App\Events\UpdateMarket;
use App\Models\RelicMission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enums\BuyMultiplierEnum;
use App\Models\GameBesarSession;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\WithdrawMultiplierEnum;
use App\Events\UpdateTearsSemiPrivate;

// Uncomment ini waktu Hari H
define('DUMMY', [
   1, 2, 3, 4, 5,
   6, 7, 8, 9, 10,
   11, 12, 13, 14, 15,
   16, 17, 18, 19, 20, 23, 26
]);

class SiController extends Controller
{
    public function ajaxResponse($isError, $msg, $haystack = [], $status = 200) {
        // DEFAULT RESPONSE
        $response = [
            'isError' => $isError,
            'msg' => $msg
        ];

        // ADDITIONAL RESPONSE
        if (count($haystack) != 0) {
            foreach ($haystack as $key => $value) {
                $response += [$key => $value];
            }
        }

        return response()->json($response, $status);
    }

    public function checkSession() {
        $session = GameBesarSession::where('open', '<=', Carbon::now())
                    ->where('close', '>=', Carbon::now())
                    ->first();

        return $session;
    }

    public function testPusher(Request $request) {
        return $this->ajaxResponse(false, "Ini Response AJAX");
    }

    public function index(){
        // Testing
        // $players = Player::select('teams.name as team_name', 'players.*')
        //             ->join('teams', 'teams.id', '=', 'players.team_id')
        //             ->get();
                    
        // Hari H
        $players = Player::select('teams.name as team_name', 'players.*')
                    ->join('teams', 'teams.id', '=', 'players.team_id')
                    ->whereNotIn('players.id', DUMMY)
                    ->get();

        $session = $this->checkSession();
        $sessionMission = $session->mission ?? 0;
        $relicMisis = RelicMission::select("relic_missions.mission_id", "relic_missions.relic_id", "relic_missions.qty")
            ->join("missions", "missions.id", "=", "relic_missions.mission_id")
            ->join("game_besar_sessions", "game_besar_sessions.mission_id", "=", "missions.id");

        if ($session) {
            $relicMisis = $relicMisis->where("game_besar_sessions.id", "=", $session->id)->get();
        } else {
            $relicMisis = $relicMisis->get();
        }

        return view('si.beranda', compact("players", "relicMisis", 'sessionMission'));
    }
    
    public function jualRelic(Request $request) {
        $currentPlayer = Player::where('id', $request->player)->get()->first();

        $currentTeam = $currentPlayer->team;

        $inventory = $currentPlayer->inventory()->get(['relic_id', 'qty']);
        $playerInventory = [
            'red' => $inventory->firstWhere('relic_id', 1),
            'purple' => $inventory->firstWhere('relic_id', 2),
            'blue' => $inventory->firstWhere('relic_id', 3),
        ];

        return view('si.jualRelic', compact('currentPlayer', 'playerInventory', "currentTeam"));
    }

    public function playerDetail(Request $request) {
        // SESSION CHECK
        $session = $this->checkSession();
        if (!$session) {
            return $this->ajaxResponse(true, "Sesi game besar belum dibuka!");
        }

        $playerId = $request->player;
        $player = Player::find($playerId);
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }
        
        // GET INVENTORY
        $inventory = $player->inventory()->get(['relic_id', 'qty']);
        $playerInventory = [];

        $red = $inventory->firstWhere('relic_id', 1)->qty;
        if (isset($red)) $playerInventory['red'] = $red;
        else $playerInventory['red'] = 0;
        
        $purple = $inventory->firstWhere('relic_id', 2)->qty;
        if (isset($purple)) $playerInventory['purple'] = $purple;
        else $playerInventory['purple'] = 0;
        
        $blue = $inventory->firstWhere('relic_id', 3)->qty;
        if (isset($blue)) $playerInventory['blue'] = $blue;
        else $playerInventory['blue'] = 0;
        
        // GET MISSION
        $sessionMissionRelics = $session->mission->relics()->get(['relic_id', 'qty']);
        $missionRelics = [
            'red' => $sessionMissionRelics->firstWhere('relic_id', 1)->qty,
            'purple' => $sessionMissionRelics->firstWhere('relic_id', 2)->qty,
            'blue' => $sessionMissionRelics->firstWhere('relic_id', 3)->qty,
        ];

        // GET SUCCESS
        $isRedeemed = Success::where('player_id', $player->id)
            ->where('mission_id', $session->mission_id)
            ->where('is_success', 1)
            ->exists();

        // UPDATE MARKET
        event(new UpdateMarket());

         // UPDATE TEARS
        event(new UpdateTearsSemiPrivate($playerId));

        return response()->json(compact('player', 'playerInventory', 'missionRelics', 'isRedeemed'), 200);
    }

    public function buyRelic (Request $request) {
       // SESSION CHECK
        $session = $this->checkSession();
        if (!$session) return $this->ajaxResponse(true, "Sesi game besar belum dibuka!");
        
        try {
            DB::beginTransaction();

            $buyerId = $request->player;
            $marketId = $request->market;
            $quantityToBuy = (int) $request->qty;

            if ($quantityToBuy <= 0) return $this->ajaxResponse(true, "Jumlah harus lebih dari 0.", ["title" => "Pembelian Gagal"]);

            $buyer = Player::find($buyerId);
            $marketOffer = Market::lockForUpdate()->find($marketId);

            if ($marketOffer->qty <= 0) return $this->ajaxResponse(true, "Penawaran ini sudah tidak tersedia.", ["title" => "Pembelian Gagal"]);
            
            if ($marketOffer->qty < $quantityToBuy) return $this->ajaxResponse(true, "Stok penawaran tidak mencukupi (tersisa: {$marketOffer->qty}).", ["title" => "Pembelian Gagal"]);
            
            $seller = Player::find($marketOffer->player_id);
            $totalCost = $marketOffer->tears * $quantityToBuy;
            $tearsToGiveSeller = $totalCost;

            $sessionMissionId = $session->mission_id;
            
            if ($seller->id == $buyer->id) {
                // WITHDRAW
                $tearsToGiveSeller = 0;

                // WITHDRAW MULTIPLIER
                if ($sessionMissionId == 1) {
                    $totalCost += $totalCost * WithdrawMultiplierEnum::FIRST->value();
                } else if ($sessionMissionId == 2) {
                    $totalCost += $totalCost * WithdrawMultiplierEnum::SECOND->value();
                } else {
                    $totalCost += $totalCost * WithdrawMultiplierEnum::THIRD->value();
                }
            } else {
                // BUY MULTIPLIER
                if ($sessionMissionId == 1) {
                    $totalCost += $totalCost * BuyMultiplierEnum::FIRST->value();
                } else if ($sessionMissionId == 2) {
                    $totalCost += $totalCost * BuyMultiplierEnum::SECOND->value();
                } else {
                    $totalCost += $totalCost * BuyMultiplierEnum::THIRD->value();
                }
            }
            
            if ($buyer->tears < $totalCost) {
                return $this->ajaxResponse(true, "Tears Anda tidak mencukupi (butuh: {$totalCost}, Anda punya: {$buyer->tears}).", ["title" => "Pembelian Gagal"]);
            }
            
            // DEDUCT BUYER'S TEARS
            $buyer->tears -= $totalCost;
            $buyer->save();
            
            // ADD RELIC TO BUYER'S INVENTORY
            Inventory::where('player_id', $buyerId)
                ->where('relic_id', $marketOffer->relic->id)
                ->increment('qty', $quantityToBuy);
            
            // DEDUCT RELIC FROM MARKET OFFER
            $marketOffer->qty -= $quantityToBuy;
            $marketOffer->save();
            
            // GIVE TEARS TO SELLER
            if ($seller) {
                $seller->tears += $tearsToGiveSeller;
                $seller->save();
            }
            
            // GET UPDATED INVENTORY
            $updatedInventory = $buyer->inventory()->get(['relic_id', 'qty']);
            $playerInventory = [
                'red' => $updatedInventory->firstWhere('relic_id', 1)->qty,
                'purple' => $updatedInventory->firstWhere('relic_id', 2)->qty,
                'blue' => $updatedInventory->firstWhere('relic_id', 3)->qty,
            ];
            
            DB::commit();
            
            // UPDATE MARKET
            event(new UpdateMarket());
            event(new UpdateTearsSemiPrivate($buyerId));
            event(new UpdateTearsSemiPrivate($seller->id));

            return $this->ajaxResponse(false, "Anda berhasil membeli {$quantityToBuy} relic {$marketOffer->relic->nama} ({$marketOffer->relic->color}) dengan harga {$totalCost} Tears!", ['playerInventory' => $playerInventory, 'tears' => $buyer->tears]);

        } catch (Exception $x){
            DB::rollBack();
            return $this->ajaxResponse(true, $x->getMessage(), ["title" => "Pembelian Gagal"], 500);
        }
    }

    public function sellRelic (Request $request) {
        // SESSION CHECK
        $session = $this->checkSession();
        if (!$session) {
            return $this->ajaxResponse(true, "Sesi game besar belum dibuka!");
        }
        
        try {
            DB::beginTransaction();

            $playerId = $request->player;
            $relicId = $request->relic;
            $qty = (int) $request->qty;
            $price = (int) $request->tears;
            
            if ($qty <= 0) { return $this->ajaxResponse(true, "Jumlah harus lebih dari 0."); }
            if ($price < 100) { return $this->ajaxResponse(true, "Harga harus setidaknya 100 tears."); }
            if ($price > 100000) { return $this->ajaxResponse(true, "Harga tidak boleh lebih dari 100000 tears."); }
           
            $player = Player::find($playerId);

            // GET RELIC AMOUNT IN INVENTORY
            $relicInInventory = $player->inventory()->get()->firstWhere('relic_id', $relicId);
            
            // CHECK IF PLAYER HAS ENOUGH RELIC
            if($relicInInventory->qty < $qty) {
                return $this->ajaxResponse(true, "Anda tidak memiliki jumlah relic yang cukup!");
            }

            // UPDATE RELIC IN INVENTORY
            $inv = Inventory::where('player_id', $playerId)
            ->where('relic_id',  $relicId)
            ->update([
                'qty'        => DB::raw("qty - {$qty}"),
                'updated_at' => now(),
            ]);

            // CREATE MARKET
            Market::create([
                'player_id' => $playerId,
                'relic_id' => $relicId,
                'qty' => $qty,
                'tears' => $price
            ]);

            $updatedInventory = $player->inventory()->get(['relic_id', 'qty']);
            $playerInventory = [
                'red' => $updatedInventory->firstWhere('relic_id', 1),
                'purple' => $updatedInventory->firstWhere('relic_id', 2),
                'blue' => $updatedInventory->firstWhere('relic_id', 3),
            ];

            DB::commit();
            
            // UPDATE MARKET
            event(new UpdateMarket());

            return $this->ajaxResponse(false, "Anda berhasil menjual relic sebanyak {$qty} dengan harga {$price} tears per relic!", compact('playerInventory'));

        } catch (Exception $x){
            DB::rollBack();
            return $this->ajaxResponse(true, $x->getMessage());
        }
    }

    public function redeemMission(Request $request, $playerId)
    {
        // SESSION CHECK
        $session = $this->checkSession();
        if (!$session) {
            return response()->json(['isError' => true, 'msg' => 'Sesi game besar belum dibuka!']);
        }

        $missionId = $session->mission_id;

        // Already redeemed check
        $alreadyRedeemed = Success::where('player_id', $playerId)
            ->where('mission_id', $missionId)
            ->where('is_success', 1)
            ->exists();

        if ($alreadyRedeemed) {
            return response()->json(['isError' => true, 'msg' => 'Anda sudah menebus misi ini.']);
        }

        try {
            DB::beginTransaction();

            $player = Player::find($playerId);
            if (!$player) {
                return response()->json(['isError' => true, 'msg' => 'Player tidak ditemukan.']);
            }

            // Get inventory
            $inventory = $player->inventory()->get(['relic_id', 'qty']);
            $playerRelics = [
                1 => $inventory->firstWhere('relic_id', 1)->qty ?? 0,
                2 => $inventory->firstWhere('relic_id', 2)->qty ?? 0,
                3 => $inventory->firstWhere('relic_id', 3)->qty ?? 0,
            ];

            // Get mission relics
            $missionRelics = $session->mission->relics()->get();
            $requiredRelics = [
                1 => $missionRelics->firstWhere('relic_id', 1)->qty ?? 0,
                2 => $missionRelics->firstWhere('relic_id', 2)->qty ?? 0,
                3 => $missionRelics->firstWhere('relic_id', 3)->qty ?? 0,
            ];

            // Check if player has enough relics
            foreach ($requiredRelics as $relicId => $requiredQty) {
                if ($playerRelics[$relicId] < $requiredQty) {
                    return response()->json(['isError' => true, 'msg' => 'Anda tidak memiliki relic yang cukup!']);
                }
            }

            // Safely decrement relics
            foreach ($requiredRelics as $relicId => $qtyToDecrement) {
                if ($qtyToDecrement > 0) {
                    $affected = Inventory::where('player_id', $playerId)
                        ->where('relic_id', $relicId)
                        ->where('qty', '>=', $qtyToDecrement)
                        ->decrement('qty', $qtyToDecrement);

                    if ($affected === 0) {
                        throw new \Exception('Gagal mengurangi relic, stok tidak cukup.');
                    }
                }
            }

            // Mark as success
            Success::create([
                'player_id' => $playerId,
                'mission_id' => $missionId,
                'is_success' => 1,
            ]);

            DB::commit();

            return response()->json(['isError' => false, 'msg' => 'Anda berhasil menyelesaikan misi!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['isError' => true, 'msg' => 'Gagal redeem mission: ' . $e->getMessage()]);
        }
    }
}
