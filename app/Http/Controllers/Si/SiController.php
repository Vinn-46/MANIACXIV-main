<?php

namespace App\Http\Controllers\Si;

use Exception;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        return view('si.beranda', compact("players"));
    }

}
