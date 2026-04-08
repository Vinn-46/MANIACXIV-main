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
        $scores = Score::with(['rallyGame', 'relicChosen', 'point'])
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
                'relics' => ['nullable', 'array'],
                'checkSessionStock' => ['nullable', 'boolean'],
            ]);

            $player = Player::findOrFail($player);
            $rallyGame = RallyGame::findOrFail($rallyGame);

            $team = $player->team;
            $point = Point::findOrFail($request->point_id);

            $checkSessionStock = $request->boolean('checkSessionStock', true);

            $score = Score::create([
                'player_id' => $player->id,
                'rally_game_id' => $rallyGame->id,
                'point_id' => $point->id
            ]);

            $player->update([
                'tears' => $player->tears + $point->point
            ]);
            
            $relicRequests = $request->input('relics', []);
            $relicModels = Relic::all()->keyBy('color');

            $gameBesarSession = GameBesarSession::where('open', '<=', now())
                ->where('close', '>=', now())
                ->first();

            if (!$gameBesarSession) {
                throw new \Exception("Session Game Besar tidak aktif.");
            }

            $redRelic = $relicRequests['red'] ?? 0;
            $blueRelic = $relicRequests['blue'] ?? 0;
            $purpleRelic = $relicRequests['purple'] ?? 0;

            $totalRequested = $redRelic + $blueRelic + $purpleRelic;

            if ($point->relic_qty < $totalRequested) {
                return back()->with('error', "Jumlah relic melebihi batas maksimal dari point ini.");
            }

            if ($checkSessionStock && $gameBesarSession) {
                if (
                    $redRelic > $gameBesarSession->red_relic_stock ||
                    $blueRelic > $gameBesarSession->blue_relic_stock ||
                    $purpleRelic > $gameBesarSession->purple_relic_stock
                ) {
                    return back()->with('error', "Stock relic tidak mencukupi.");
                }
            }

            RelicChosen::create([
                'score_id' => $score->id,
                'red_relic_qty' => $relicRequests['red'] ?? 0,
                'blue_relic_qty' => $relicRequests['blue'] ?? 0,
                'purple_relic_qty' => $relicRequests['purple'] ?? 0,
            ]);

            foreach (['red', 'blue', 'purple'] as $color) {
                $qty = $relicRequests[$color] ?? 0;

                if ($qty > 0 && isset($relicModels[$color])) {
                    Inventory::updateOrCreate(
                        ['player_id' => $player->id, 'relic_id' => $relicModels[$color]->id],
                        ['qty' => DB::raw("qty + $qty")]
                    );

                    if ($checkSessionStock) {
                        $gameBesarSession->decrement("{$color}_relic_stock", $qty);
                    }
                }
            }

            // Fire events after successful creation
            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());

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
                'relics' => ['nullable', 'array'],
                'checkSessionStock' => ['nullable', 'boolean'],
                'addBackSessionStock' => ['nullable', 'boolean'],
            ]);

            $score = Score::findOrFail($score);
            $player = $score->player;
            $oldPoint = $score->point;
            $newPoint = Point::find($request->get('point_id'));

            $oldTears = $oldPoint->point;
            $newTears = $newPoint->point;

            $team = $player->team;

            $checkSessionStock = $request->boolean('checkSessionStock', true);
            $addBackSessionStock = $request->boolean('addBackSessionStock', true);

            $score->update([
                'point_id' => $newPoint->id
            ]);

            $player->update([
                'tears' => $player->tears - $oldTears + $newTears
            ]);

            $relicRequests = $request->input('relics', []);
            $relicModels = Relic::all()->keyBy('color');

            $gameBesarSession = GameBesarSession::where('open', '<=', now())
                ->where('close', '>=', now())
                ->first();

            if (!$gameBesarSession) {
                throw new \Exception("[Error] Sesi GameBesar tidak ditemukan atau belum aktif.");
            }

            $relicChosen = RelicChosen::where('score_id', $score->id)->first();

            if ($relicChosen) {
                foreach (['red', 'blue', 'purple'] as $color) {
                    $qty = $relicChosen->{$color . '_relic_qty'} ?? 0;
                    if ($qty > 0 && isset($relicModels[$color])) {
                        Inventory::where('player_id', $player->id)
                            ->where('relic_id', $relicModels[$color]->id)
                            ->decrement('qty', $qty);
                        if ($addBackSessionStock && $gameBesarSession) {
                            $gameBesarSession->increment("{$color}_relic_stock", $qty);
                        }
                    }
                }

                $relicChosen->delete();
            }

            $redRelic = $relicRequests['red'] ?? 0;
            $blueRelic = $relicRequests['blue'] ?? 0;
            $purpleRelic = $relicRequests['purple'] ?? 0;

            $totalRequested = $redRelic + $blueRelic + $purpleRelic;

            if ($newPoint->relic_qty < $totalRequested) {
                return back()->with('error', "Jumlah relic melebihi batas maksimal dari point ini.");
            }

            if ($checkSessionStock && $gameBesarSession) {
                if (
                    $redRelic > $gameBesarSession->red_relic_stock ||
                    $blueRelic > $gameBesarSession->blue_relic_stock ||
                    $purpleRelic > $gameBesarSession->purple_relic_stock
                ) {
                    return back()->with('error', "Stock relic tidak mencukupi.");
                }
            }

            RelicChosen::create([
                'score_id' => $score->id,
                'red_relic_qty' => $redRelic,
                'blue_relic_qty' => $blueRelic,
                'purple_relic_qty' => $purpleRelic,
            ]);

            foreach (
                [
                    'red' => $redRelic, 
                    'blue' => $blueRelic, 
                    'purple' => $purpleRelic
                ] as $color => $qty) {
                if ($qty > 0 && isset($relicModels[$color])) {
                    Inventory::where('player_id', $player->id)
                        ->where('relic_id', $relicModels[$color]->id)
                        ->increment('qty', $qty);

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
            return back()->with('error', "[Error] " . $e->getMessage());
        }
    }

    public function deleteScore(Request $request, int $score)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'add_back_session_stock' => ['nullable', 'boolean'],
            ]);
            
            $score = Score::findOrFail($score);
            $player = $score->player;
            $point = $score->point;
            $team = $player->team;
            
            $addBackSessionStock = $request->boolean('add_back_session_stock', true);
            
            $gameBesarSession = GameBesarSession::where('open', '<=', now())
                ->where('close', '>=', now())
                ->first();

            $relicModels = Relic::all()->keyBy('color');
            $relicChosen = RelicChosen::where('score_id', $score->id)->first();

            if ($relicChosen) {
                foreach (['red', 'blue', 'purple'] as $color) {
                    $qty = $relicChosen->{$color . '_relic_qty'} ?? 0;

                    if ($qty > 0 && isset($relicModels[$color])) {
                        Inventory::where('player_id', $player->id)
                            ->where('relic_id', $relicModels[$color]->id)
                            ->decrement('qty', $qty);

                        if ($addBackSessionStock && $gameBesarSession) {
                            $gameBesarSession->increment("{$color}_relic_stock", $qty);
                        }
                    }
                }

                $relicChosen->delete();
            }

            $player->update([
                'tears' => max(0, $player->tears - $point->point)
            ]);

            $score->delete();

            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());

            DB::commit();

            return back()->with('deleteSuccess', "Score & relic berhasil dihapus dari tim <strong>{$team->name}</strong>.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "[Error] " . $e->getMessage());
        }
    }
}
