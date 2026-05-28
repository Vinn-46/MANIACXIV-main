<?php

namespace App\Http\Controllers\Penpos;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Team;
use App\Models\Point;
use App\Models\Score;
use App\Models\Player;
use App\Events\InformSI;
use App\Models\RallyGame;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenposController extends Controller
{
    public function index()
    {
        $points = Point::where('type', Auth::user()->rallyGame->type)->get();
        $scores = Score::where('rally_game_id', Auth::user()->rallyGame->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('penpos.index', compact('points', 'scores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tim' => ['required'],
            'point_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $team = Team::where('name', $request->get('tim'))->first();
            if ($team == null)
                throw new \Exception("Could not find team named '{$request->get('tim')}'");

            $player = Player::where('team_id', $team->id)->first();

            $flag = Score::where('player_id', $player->id)
                ->where('rally_game_id', Auth::user()->rallyGame->id)
                ->exists();
            if ($flag) {
                return response()->json([
                    'msg' => 'YES',
                    'error_code' => 'TEAM_ALREADY_PLAYED',
                    'error_message' => 'Tim sudah pernah bermain di pos ini.',
                ], 409);
            }

            $point = Point::find($request->get('point_id'));

            $score = Score::create([
                'rally_game_id' => Auth::user()->rallyGame->id,
                'player_id' => $player->id,
                'point_id' => $point->id
            ]);

            $player->update([
                'honor' => $player->honor + $point->honor_reward,
                'peluru' => $player->peluru + $point->peluru_reward,
            ]);

            $scores = RallyGame::getPenposScores(Auth::user()->rallyGame->id);

            DB::commit();

            return response()->json([
                'msg' => 'NO',
                'point' => $point,
                'team' => $team,
                'scores' => $scores,
                'desc' => 'Berhasil menambahkan poin ke Tim ' . $team->name,
            ], 200);

        } catch (\Exception $x) {
            DB::rollBack();
            return response()->json([
                'msg' => 'ERROR',
                'error_code' => 'SERVER_EXCEPTION',
                'error_message' => "[HUBUNGI SI] " . $x->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $score = Score::findOrFail($request->scoreId);
            $player = Player::findOrFail($score->player_id);
            $team = Team::findOrFail($player->team_id);
            $rallyGame = RallyGame::where("user_id", $request->user_id)->firstOrFail();
            $desc = 'Berhasil Menghapus Score untuk Tim ' . $team->name;

            $honor_reward = $score->point->honor_reward;
            $peluru_reward = $score->point->peluru_reward;
            $newHonor = max($player->honor - $honor_reward, 0);
            $newPeluru = max($player->peluru - $peluru_reward, 0);

            $player->update([
                'honor' => $newHonor,
                'peluru' => $newPeluru
            ]);

            // Delete score
            $score->delete();

            // Refresh scores
            $scores = RallyGame::getPenposScores($rallyGame->id);

            DB::commit();

            return response()->json([
                'msg' => $desc,
                'scores' => $scores,
            ], 200);
        } catch (\Exception $x) {
             DB::rollBack();

            return response()->json([
                'msg' => $x->getMessage(),
                'scores' => [],
                'catch' => 'ini di catch'
            ], 500);
        }
    }


    public function informSI(Request $request)
    {
        $rallyGameId = $request->input('rallyGame_id');

        Notification::create([
            'rally_game_id' => $rallyGameId,
            'called_at' => now(),
        ]);

        broadcast(new InformSI($rallyGameId));

        return response()->json(['success' => true]);
    }
}
