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
        $relicMisis = collect([]); // Remove relic missions

        return view('si.beranda', compact("players", "relicMisis", 'sessionMission'));
    }

}
