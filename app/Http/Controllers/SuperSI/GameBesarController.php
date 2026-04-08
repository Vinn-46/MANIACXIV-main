<?php

namespace App\Http\Controllers\SuperSI;

use Carbon\Carbon;
use App\Models\Alpha;
use App\Models\Score;
use App\Models\Mission;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\GameBesarSession;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\GameBesarRelicStockEnum;
use Illuminate\Support\Facades\Session;

class GameBesarController extends Controller
{

    public function index()
    {
        $sessions = GameBesarSession::all();
        $missions = Mission::all();
        
        return view('supersi.gamebesar.index', compact('sessions', 'missions'));
    }

    public function sessionDetail(GameBesarSession $session)
    {
        $missions = Mission::all();
        return view('supersi.gamebesar.session', compact('session', 'missions'));
    }

    public function addSession(Request $request)
    {
        $request->validate([
            'mission_id' => ['required'],
            'open' => ['required'],
            'close' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $open = strtotime($request->get('open'));
            $close = strtotime($request->get('close'));

            $openDate = date("Y-m-d H:i", $open);
            $closeDate = date("Y-m-d H:i", $close);

            $missionId = $request->get('mission_id');
            
            // ASSIGN STOCK
            $redStock = 0;
            $purpleStock = 0;
            $blueStock = 0;
            if ($missionId == 1) {
                $redStock = GameBesarRelicStockEnum::FIRST_RED->value();
                $purpleStock = GameBesarRelicStockEnum::FIRST_PURPLE->value();
                $blueStock = GameBesarRelicStockEnum::FIRST_BLUE->value();
            } else if ($missionId == 2) {
                $redStock = GameBesarRelicStockEnum::SECOND_RED->value();
                $purpleStock = GameBesarRelicStockEnum::SECOND_PURPLE->value();
                $blueStock = GameBesarRelicStockEnum::SECOND_BLUE->value();
            } else if ($missionId == 3) {
                $redStock = GameBesarRelicStockEnum::THIRD_RED->value();
                $purpleStock = GameBesarRelicStockEnum::THIRD_PURPLE->value();
                $blueStock = GameBesarRelicStockEnum::THIRD_BLUE->value();
            }

            GameBesarSession::create([
                'mission_id' => $request->get('mission_id'),
                'open' => $openDate,
                'close' => $closeDate,
                'red_relic_stock' => $redStock,
                'purple_relic_stock' => $purpleStock,
                'blue_relic_stock' => $blueStock
            ]);

            DB::commit();

            return back()->with('addSuccess', "Berhasil menambahkan Sesi baru!");
        } catch (\Exception $x) {
            DB::rollBack();
            return back()->with('error', $x->getMessage());
        }
    }

    public function updateSession(GameBesarSession $session, Request $request)
    {
        $request->validate([
            'mission_id' => ['required'],
            'open' => ['required'],
            'close' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $openDate = date("Y-m-d H:i", strtotime($request->get('open')));
            $closeDate = date("Y-m-d H:i", strtotime($request->get('close')));
            $missionId = $request->get('mission_id');

            // Prepare base update payload
            $updateData = [
                'mission_id' => $missionId,
                'open' => $openDate,
                'close' => $closeDate,
            ];

            if ($request->has('reset_session_stock_update')) {
                $redStock = 0;
                $purpleStock = 0;
                $blueStock = 0;

                if ($missionId == 1) {
                    $redStock = GameBesarRelicStockEnum::FIRST_RED->value();
                    $purpleStock = GameBesarRelicStockEnum::FIRST_PURPLE->value();
                    $blueStock = GameBesarRelicStockEnum::FIRST_BLUE->value();
                } else if ($missionId == 2) {
                    $redStock = GameBesarRelicStockEnum::SECOND_RED->value();
                    $purpleStock = GameBesarRelicStockEnum::SECOND_PURPLE->value();
                    $blueStock = GameBesarRelicStockEnum::SECOND_BLUE->value();
                } else if ($missionId == 3) {
                    $redStock = GameBesarRelicStockEnum::THIRD_RED->value();
                    $purpleStock = GameBesarRelicStockEnum::THIRD_PURPLE->value();
                    $blueStock = GameBesarRelicStockEnum::THIRD_BLUE->value();
                }

                $updateData['red_relic_stock'] = $redStock;
                $updateData['purple_relic_stock'] = $purpleStock;
                $updateData['blue_relic_stock'] = $blueStock;
            }

            // Perform update
            $session->update($updateData);

            DB::commit();
            return back()->with('updateSuccess', "Berhasil meng-update Sesi Game Besar!");
        } catch (\Exception $x) {
            DB::rollBack();
            return back()->with('error', $x->getMessage());
        }
    }

    public function closeSession(GameBesarSession $session)
    {
        DB::beginTransaction();
        try {
            $session->update([
                'close' => Carbon::now()->format('Y-m-d H:i')
            ]);

            DB::commit();
            return back()->with('closeSuccess', 'Sesi berhasil ditutup!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menutup sesi: ' . $e->getMessage());
        }
    }

    public function resetInventory()
    {
        try {
            Inventory::where('qty', '>', 0)
                ->whereHas('player.team', function ($query) {
                    $query->where('name', '!=', 'SYSTEM');
                })->update(['qty' => 0]);
                
            return back()->with('success', 'All player inventories have been reset.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset inventories: ' . $e->getMessage());
        }
    }
}
