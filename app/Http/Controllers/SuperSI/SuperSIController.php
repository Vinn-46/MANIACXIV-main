<?php

namespace App\Http\Controllers\SuperSI;

use App\Models\Log;
use App\Models\Point;
use App\Models\Score;
use App\Models\Contest;
use App\Models\RallyGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperSIController extends Controller
{
    public function index()
    {
        $rallyGames = RallyGame::withCount('scores')
                ->orderByRaw("CASE type
                    WHEN 'single' THEN 1
                    WHEN 'battle' THEN 2
                    WHEN 'inferno' THEN 3
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
            ->select('scores.*', 'points.honor_reward')
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

            $team = $player->team;

            // Calculate currency adjustments
            $oldHonor = $oldPoint->honor_reward;
            $oldPeluru = $oldPoint->peluru_reward;
            $newHonorReward = $newPoint->honor_reward;
            $newPeluruReward = $newPoint->peluru_reward;

            // Update Player Currency
            $newPlayerHonor = max($player->honor - $oldHonor + $newHonorReward, 0);
            $newPlayerPeluru = max($player->peluru - $oldPeluru + $newPeluruReward, 0);

            $player->update([
                'honor' => $newPlayerHonor,
                'peluru' => $newPlayerPeluru
            ]);

            // Update Score
            $score->update([
                'point_id' => $newPoint->id
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

            // Reverse Player Currency
            $honor_reward = $point->honor_reward;
            $peluru_reward = $point->peluru_reward;

            $player->update([
                'honor' => max($player->honor - $honor_reward, 0),
                'peluru' => max($player->peluru - $peluru_reward, 0)
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

        $players = \App\Models\Player::with(['team', 'scores.point'])
            ->whereHas('team', function($q) {
                $q->where('name', '!=', 'SYSTEM');
            })->get();

        $leaderboard = [];

        foreach ($players as $player) {
            $total_honor = $player->scores->sum(function($score) {
                return $score->point ? $score->point->honor_reward : 0;
            });
            $pos_menang = $player->scores->filter(function($score) {
                return $score->point && $score->point->condition === 'win';
            })->count();
            $pos_dimainkan = $player->scores->count();
            $rally_score = (($total_honor / 2800) * 100 * 0.30)
                         + (($pos_menang / 16) * 100 * 0.20)
                         + (($pos_dimainkan / 16) * 100 * 0.10);
            $gamebes_poin = $player->game_besar_points + $player->bonus_points;
            $gamebes_score = ($gamebes_poin / 170) * 100 * 0.40;
            $total_score = $rally_score + $gamebes_score;

            $leaderboard[] = (object) [
                'player_id' => $player->id,
                'team_name' => $player->team->name,
                'total_honor' => $total_honor,
                'pos_menang' => $pos_menang,
                'pos_dimainkan' => $pos_dimainkan,
                'gamebes_poin' => $gamebes_poin,
                'rally_score' => $rally_score,
                'gamebes_score' => $gamebes_score,
                'total_score' => $total_score,
            ];
        }

        // Sort descending by total score, then alphabetically by team name
        usort($leaderboard, function($a, $b) {
            if ($b->total_score == $a->total_score) {
                return strcmp($a->team_name, $b->team_name);
            }
            return $b->total_score <=> $a->total_score;
        });

        return view('supersi.leaderboard.index', compact('leaderboard'));
    }

    public function summarize(Request $request)
    {
        // For summarize, we just reuse the leaderboard calculation
        // Since we don't have contest logic yet (it was broken in original anyway)
        // We will just export the full leaderboard
        $players = \App\Models\Player::with(['team', 'scores.point'])
            ->whereHas('team', function($q) {
                $q->where('name', '!=', 'SYSTEM');
            })->get();

        $leaderboard = [];

        foreach ($players as $player) {
            $total_honor = $player->scores->sum(function($score) {
                return $score->point ? $score->point->honor_reward : 0;
            });
            $pos_menang = $player->scores->filter(function($score) {
                return $score->point && $score->point->condition === 'win';
            })->count();
            $pos_dimainkan = $player->scores->count();
            $rally_score = (($total_honor / 2800) * 100 * 0.30)
                         + (($pos_menang / 16) * 100 * 0.20)
                         + (($pos_dimainkan / 16) * 100 * 0.10);
            $gamebes_poin = $player->game_besar_points + $player->bonus_points;
            $gamebes_score = ($gamebes_poin / 170) * 100 * 0.40;
            $total_score = $rally_score + $gamebes_score;

            $leaderboard[] = [
                'Rank' => 0,
                'Player ID' => $player->id,
                'Team Name' => $player->team->name,
                'Total Honor' => $total_honor,
                'Pos Menang' => $pos_menang,
                'Pos Dimainkan' => $pos_dimainkan,
                'Game Besar Points' => $gamebes_poin,
                'Rally Score (60%)' => $rally_score,
                'Gamebes Score (40%)' => $gamebes_score,
                'Final Total Score' => $total_score,
            ];
        }

        usort($leaderboard, function($a, $b) {
            if ($b['Final Total Score'] == $a['Final Total Score']) {
                return strcmp($a['Team Name'], $b['Team Name']);
            }
            return $b['Final Total Score'] <=> $a['Final Total Score'];
        });

        // Add ranks
        foreach($leaderboard as $idx => &$row) {
            $row['Rank'] = $idx + 1;
        }

        return response()->json(['scores' => $leaderboard]);
    }
}
