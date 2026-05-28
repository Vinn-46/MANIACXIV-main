<?php

namespace App\Http\Controllers\SuperSI;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameBesarController extends Controller
{

    public function index()
    {
        $players = \App\Models\Player::with('team')->whereHas('team', function($q) {
            $q->where('name', '!=', 'SYSTEM');
        })->get();
        
        return view('supersi.gamebesar.index', compact('players'));
    }

    public function updatePoints(Request $request, \App\Models\Player $player)
    {
        $request->validate([
            'game_besar_points' => 'required|numeric|min:0',
            'bonus_points' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $player->update([
                'game_besar_points' => $request->game_besar_points,
                'bonus_points' => $request->bonus_points,
            ]);

            DB::commit();

            return back()->with('updateSuccess', "Berhasil mengupdate poin Game Besar untuk tim {$player->team->name}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Gagal mengupdate: " . $e->getMessage());
        }
    }
}
