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
            ->select('scores.*', 'points.point')
            ->orderBy('scores.updated_at', 'DESC')
            ->with('relicChosen')
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
                'relics' => ['nullable', 'array'],
                'checkSessionStock' => ['nullable', 'boolean'], // Bypass check session stock or not
                'addBackSessionStock' => ['nullable', 'boolean'], // Add back the relic to session stock or not
            ]);

            $player = $score->player;
            $oldPoint = $score->point;
            $newPoint = Point::find($request->get('point_id'));

            $oldTears = $oldPoint->point;
            $newTears = $newPoint->point;

            $team = $player->team;

            // Checking defaulted to true
            $checkSessionStock = $request->boolean('checkSessionStock', true);
            $addBackSessionStock = $request->boolean('addBackSessionStock', true);

            // Update Score
            $score->update([
                'point_id' => $newPoint->id
            ]);

            // Update Tears
            $player->update([
                'tears' => $player->tears - $oldTears + $newTears // Remove old point value and add new point value
            ]);

            // Relics
            $relicRequests = $request->input('relics', []);
            $relicModels = Relic::all()->keyBy('color');

            // Get GameBesarSession
            $gameBesarSession = GameBesarSession::where('open', '<=', now())
                ->where('close', '>=', now())
                ->first();

            if (!$gameBesarSession) {
                throw new \Exception("[HUBUNGI SI] Sesi GameBesar tidak ditemukan atau belum aktif.");
            }

            $relicChosen = RelicChosen::where('score_id', $score->id)->first();

            if ($relicChosen) {
                // Reverse previous inventory
                foreach (['red', 'blue', 'purple'] as $color) {
                    $qty = $relicChosen->{$color . '_relic_qty'} ?? 0;
                    if ($qty > 0 && isset($relicModels[$color])) {
                        Inventory::where('player_id', $player->id)
                            ->where('relic_id', $relicModels[$color]->id)
                            ->decrement('qty', $qty); // Reduce old qty from inventory
                        if ($addBackSessionStock && $gameBesarSession) {
                            $gameBesarSession->increment("{$color}_relic_stock", $qty); // Add old qty back to stock
                        }
                    }
                }

                $relicChosen->delete(); // Delete previous RelicChosen
            }

            // Apply new relics (if any)
            $redRelic = $relicRequests['red'] ?? 0;
            $blueRelic = $relicRequests['blue'] ?? 0;
            $purpleRelic = $relicRequests['purple'] ?? 0;

            $totalRequested = $redRelic + $blueRelic + $purpleRelic;

            if ($newPoint->relic_qty < $totalRequested) {
                return back()->with('error', "Jumlah relic melebihi batas maksimal dari point ini.");
            }

            // Check stock
            if ($checkSessionStock && $gameBesarSession) {
                if (
                    $redRelic > $gameBesarSession->red_relic_stock ||
                    $blueRelic > $gameBesarSession->blue_relic_stock ||
                    $purpleRelic > $gameBesarSession->purple_relic_stock
                ) {
                    return back()->with('error', "Stock relic tidak mencukupi.");
                }
            }

            // Create new RelicChosen
            RelicChosen::create([
                'score_id' => $score->id,
                'red_relic_qty' => $redRelic,
                'blue_relic_qty' => $blueRelic,
                'purple_relic_qty' => $purpleRelic,
            ]);

            // Add relics to inventory & reduce session stock
            foreach (
                [
                    'red' => $redRelic, 
                    'blue' => $blueRelic, 
                    'purple' => $purpleRelic
                ] as $color => $qty) {
                if ($qty > 0 && isset($relicModels[$color])) {
                    Inventory::where('player_id', $player->id)
                        ->where('relic_id', $relicModels[$color]->id)
                        ->increment('qty', $qty); // Add new qty to inventory

                    if ($checkSessionStock && $gameBesarSession) {
                        $gameBesarSession->decrement("{$color}_relic_stock", $qty);
                    }
                }
            }

            // Fire events
            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());

            DB::commit();

            return back()->with('updateSuccess', "Score & Relic berhasil di-update untuk Tim <strong>{$team->name}</strong>.");
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

            $relicChosen = RelicChosen::where('score_id', $score->id)->first();
            $relicModels = Relic::all()->keyBy('color');

            $gameBesarSession = GameBesarSession::where('open', '<=', now())
                ->where('close', '>=', now())
                ->first();

            $shouldAddBackStock = $request->has('add_back_session_stock');

            if ($relicChosen) {
                foreach (['red', 'blue', 'purple'] as $color) {
                    $qty = $relicChosen->{$color . '_relic_qty'} ?? 0;

                    if ($qty > 0 && isset($relicModels[$color])) {
                        // Reduce from player's inventory
                        Inventory::where('player_id', $player->id)
                            ->where('relic_id', $relicModels[$color]->id)
                            ->decrement('qty', $qty);

                        // Return to session stock (if session found)
                        if ($shouldAddBackStock && $gameBesarSession) {
                            $gameBesarSession->increment("{$color}_relic_stock", $qty);
                        }
                    }
                }

                $relicChosen->delete();
            }

            // Subtract the tears (point) from the player
            $player->update([
                'tears' => $player->tears - $point->point
            ]);

            // Delete score
            $score->delete();

            // Fire events
            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());

            DB::commit();

            return back()->with("success", "Berhasil menghapus Score & Relic dari Tim <strong>{$team->name}</strong>.");
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
                    (SELECT IFNULL(SUM(ps.point/2400 * 30), 0) FROM players p2	-- Kolom 3
                        INNER JOIN scores sc ON sc.player_id = p2.id
                        LEFT JOIN points ps ON sc.point_id = ps.id
                        WHERE NOT t.name = 'SYSTEM' AND p2.id = p.id) AS r_tears,
                    fJumPosDimenangkan(p.id) AS r_jumlah_pos_win, 	-- Kolom 4
                    fJumPosDimainkan(p.id) AS r_jumlah_pos_dimainkan, 	-- Kolom 5
                    ((SELECT IFNULL(SUM(ps.point/2400 * 30), 0) FROM players p2	-- Kolom 6
                        INNER JOIN scores sc ON sc.player_id = p2.id
                        LEFT JOIN points ps ON sc.point_id = ps.id
                        WHERE NOT t.name = 'SYSTEM' AND p2.id = p.id)
                        +
                        fJumPosDimenangkan(p.id)
                        +
                        fJumPosDimainkan(p.id)
                        )AS point_rally,
                        IFNULL(SUM(m.point * 0.4), 0) AS gb_points,	-- Kolom 7
                    (IFNULL(SUM(m.point * 0.4), 0)
                        +
                        (SELECT IFNULL(SUM(ps.point/2400 * 30), 0) FROM players p2	-- Kolom 8
                            INNER JOIN scores sc ON sc.player_id = p2.id
                            LEFT JOIN points ps ON sc.point_id = ps.id
                            WHERE NOT t.name = 'SYSTEM' AND p2.id = p.id)
                        +
                        fJumPosDimenangkan(p.id)
                        +
                        fJumPosDimainkan(p.id)
                        ) AS total_score,
                    FLOOR(p.tears / 10) AS converted_points
                FROM players p
                INNER JOIN teams t ON p.team_id = t.id
                LEFT JOIN successes s ON s.player_id = p.id AND s.is_success = 1
                LEFT JOIN missions m ON s.mission_id = m.id
                WHERE NOT t.name = 'SYSTEM'
                GROUP BY p.id, t.name, p.tears
	            ORDER BY total_score DESC, gb_points DESC, converted_points DESC, t.name ASC;
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
            ->leftJoin('successes as s', function($join) use ($contest_id) {
                $join->on('s.player_id', '=', 'p.id')
                    ->where('s.is_success', true)
                    ->where('s.contest_id', $contest_id);
            })
            ->leftJoin('missions as m', 's.mission_id', '=', 'm.id')
            ->select(
                'p.id as Player ID',
                't.name as Team Name',
                DB::raw('COALESCE(SUM(m.point), 0) as Mission Points'),
                'p.tears as Tears',
                DB::raw('FLOOR(p.tears / 10) as Converted Points'),
                DB::raw('(COALESCE(SUM(m.point), 0) + FLOOR(p.tears / 10)) as Total Score')
            )
            ->where('p.contest_id', $contest_id) // track contest in players ?
            ->groupBy('p.id', 't.name', 'p.tears')
            ->orderByDesc('Total Score')
            ->get();

        return response()->json(['scores' => $scores]);
    }
}
