<?php

namespace App\Http\Controllers\SuperSI;

use App\Models\Point;
use App\Models\Relic;
use App\Models\Score;
use App\Models\Player;
use App\Models\Mission;
use App\Models\Inventory;
use App\Models\RallyGame;
use App\Models\RelicChosen;
use Illuminate\Http\Request;
use App\Models\GameBesarSession;
use Illuminate\Support\Facades\DB;
use App\Events\UpdateAvailableStock;
use App\Http\Controllers\Controller;
use App\Events\UpdateTearsSemiPrivate;

class PlayerController extends Controller
{
    public function index()
    {
        $dummy = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                    11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 
                    23, 26];

        $players = Player::whereNotIn('id', $dummy)
            ->with(['inventory.relic'])
            ->get();

        // $players = Player::with(['successes'])->get(); // Komen untuk hari h

        $missions = Mission::all(); // to loop over missions
        return view('supersi.player.index', compact('players', 'missions'));
    }

    public function log(Player $player)
    {
        $logs = $player->logs()->latest()->get();
        return view('supersi.player.log', compact('player', 'logs'));
    }

    public function marketLog(Player $player)
    {
        $logs = $player->marketLogs()->latest()->get();
        return view('supersi.player.marketlog', compact('player', 'logs'));
    }

    public function score(Player $player)
    {
        $scores = Score::where('player_id', '=', $player->id)->get();
        return view('supersi.player.score', compact('scores'));
    }

    public function rallyGame(Player $player)
    {
        $team = $player->team;
        $rallyGames = RallyGame::orderByRaw("CASE type 
                WHEN 'single' THEN 1 
                WHEN 'battle' THEN 2 
                WHEN 'hel' THEN 3 
                ELSE 4 END")
            ->orderBy('name', "ASC")
            ->get();
        $points = Point::all();
        $scores = Score::with(['rallyGame', 'point'])
            ->where('player_id', $player->id)
            ->get()
            ->keyBy('rally_game_id');

        return view('supersi.player.rallygame', compact('player', 'team', 'rallyGames', 'scores', 'points'));
    }

    public function createScore(Request $request, int $player, int $rallyGame)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'point_id' => ['required', 'exists:points,id'],
            ]);

            $player = Player::findOrFail($player);
            $rallyGame = RallyGame::findOrFail($rallyGame);

            $team = $player->team;
            $point = Point::findOrFail($request->point_id);

            $score = Score::create([
                'player_id' => $player->id,
                'rally_game_id' => $rallyGame->id,
                'point_id' => $point->id
            ]);

            $player->update([
                'points' => $player->points + $point->value
            ]);

            DB::commit();

            return back()->with('addSuccess', "Score berhasil ditambahkan untuk tim <strong>{$team->name}</strong>.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "[Error] " . $e->getMessage());
        }
    }

    public function updateScore(int $score, Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'point_id' => ['required', 'exists:points,id'],
            ]);

            $score = Score::findOrFail($score);
            $player = $score->player;
            $oldPoint = $score->point;
            $newPoint = Point::find($request->get('point_id'));

            $oldPoints = $oldPoint->value;
            $newPoints = $newPoint->value;

            $team = $player->team;

            $score->update([
                'point_id' => $newPoint->id
            ]);

            $player->update([
                'points' => $player->points - $oldPoints + $newPoints
            ]);

            DB::commit();

            return back()->with('updateSuccess', "Score berhasil di-update untuk Tim <strong>{$team->name}</strong>.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "[Error] " . $e->getMessage());
        }
    }

    public function deleteScore(Request $request, int $score)
    {
        DB::beginTransaction();

        try {
            $score = Score::findOrFail($score);
            $player = $score->player;
            $point = $score->point;
            $team = $player->team;
            
            $player->update([
                'points' => max(0, $player->points - $point->value)
            ]);

            $score->delete();

            DB::commit();

            return back()->with('deleteSuccess', "Score berhasil dihapus dari tim <strong>{$team->name}</strong>.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "[Error] " . $e->getMessage());
        }
    }
}
