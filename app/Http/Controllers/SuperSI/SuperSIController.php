<?php

namespace App\Http\Controllers\SuperSI;

use App\Models\Log;
use App\Models\Point;
use App\Models\Relic;
use App\Models\Score;
use App\Models\Contest;
use App\Models\Inventory;
use App\Models\RallyGame;
use App\Models\RelicChosen;
use Illuminate\Http\Request;
use App\Models\GameBesarSession;
use Illuminate\Support\Facades\DB;
use App\Events\UpdateAvailableStock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\UpdateTearsSemiPrivate;

class SuperSIController extends Controller
{
    public function index()
    {
        $rallyGames = RallyGame::withCount('scores')
                ->orderByRaw("CASE type 
                    WHEN 'single' THEN 1 
                    WHEN 'battle' THEN 2 
                    WHEN 'hel' THEN 3 
                    ELSE 4 END")
                ->orderBy('scores_count', "DESC")
                ->orderBy('name', "ASC")
                ->get();
                            
        return view('supersi.rally.index', compact('rallyGames'));
    }

    public function rallyDetail(RallyGame $rallyGame)
    {
        $scores = $rallyGame->scores()
            ->with('point')
            ->join('points', 'scores.point_id', '=', 'points.id')
            ->select('scores.*', 'points.value')
            ->orderBy('scores.updated_at', 'DESC')
            ->paginate(10);

        $points = Point::where('type', $rallyGame->type)
                    ->get();

        return view('supersi.rally.rally', compact('rallyGame', 'scores', 'points'));
    }

    public function updateScore(RallyGame $rallyGame, Score $score, Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'point_id' => ['required', 'exists:points,id'],
            ]);

            $player = $score->player;
            $oldPoint = $score->point;
            $newPoint = Point::find($request->get('point_id'));

            $oldPoints = $oldPoint->value;
            $newPoints = $newPoint->value;

            $team = $player->team;

            // Update Score
            $score->update([
                'point_id' => $newPoint->id
            ]);

            // Update Points
            $player->update([
                'points' => $player->points - $oldPoints + $newPoints
            ]);

            DB::commit();

            return back()->with('updateSuccess', "Score berhasil di-update untuk Tim <strong>{$team->name}</strong>.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "[HUBUNGI SI] " . $e->getMessage());
        }
    }

    public function deleteScore(RallyGame $rallyGame, Score $score, Request $request)
    {
        DB::beginTransaction();

        try {
            $player = $score->player;
            $point = $score->point;
            $team = $player->team;

            // Subtract the points from the player
            $player->update([
                'points' => $player->points - $point->value
            ]);

            // Delete score
            $score->delete();

            DB::commit();

            return back()->with("success", "Berhasil menghapus Score dari Tim <strong>{$team->name}</strong>.");
        } catch (\Exception $x) {
            DB::rollBack();
            return back()->with("error", "[HUBUNGI SI] " . $x->getMessage());
        }
    }

    public function leaderboard(Request $request)
    {
        $contests = Contest::all();
        $leaderboard = DB::select("
            SELECT 
                p.id AS player_id, 	-- Kolom 1
                t.name AS team_name,	-- Kolom 2
                     p.points AS total_score
                FROM players p
                INNER JOIN teams t ON p.team_id = t.id
                WHERE NOT t.name = 'SYSTEM'
                GROUP BY p.id, t.name, p.points
	            ORDER BY total_score DESC, t.name ASC;
        ");

        return view('supersi.leaderboard.index', compact('leaderboard', 'contests'));
    }

    public function summarize(Request $request)
    {
        $contest_id = $request->input('contest_id');

        // Basic validation
        if (!$contest_id) {
            return response()->json(['error' => 'Contest ID required'], 400);
        }

        // Need to customize this query to match the scoring rules

        $scores = DB::table('players as p')
            ->join('teams as t', 'p.team_id', '=', 't.id')
            ->select(
                'p.id as Player ID',
                't.name as Team Name',
                'p.points as Total Score'
            )
            ->where('p.contest_id', $contest_id) // track contest in players ?
            ->groupBy('p.id', 't.name', 'p.points')
            ->orderByDesc('Total Score')
            ->get();

        return response()->json(['scores' => $scores]);
    }
}
