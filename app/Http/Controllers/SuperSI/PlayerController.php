<?php

namespace App\Http\Controllers\SuperSI;

use App\Models\Point;
use App\Models\Score;
use App\Models\Player;

use App\Models\RallyGame;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::whereHas('team', function($q) {
                $q->where('name', '!=', 'SYSTEM');
            })
            ->with(['team'])
            ->get();

        return view('supersi.player.index', compact('players'));
    }

    public function log(Player $player)
    {
        $logs = $player->logs()->latest()->get();
        return view('supersi.player.log', compact('player', 'logs'));
    }



    public function score(Player $player)
    {
        $scores = Score::where('player_id', '=', $player->id)->get();
        return view('supersi.player.score', compact('player', 'scores'));
    }

    public function rallyGame(Player $player)
    {
        $team = $player->team;
        $rallyGames = RallyGame::orderByRaw("CASE type
                WHEN 'single' THEN 1
                WHEN 'battle' THEN 2
                WHEN 'inferno' THEN 3
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

            // Add Player Currency
            $honor_reward = $point->honor_reward;
            $peluru_reward = $point->peluru_reward;

            $player->update([
                'honor' => max($player->honor + $honor_reward, 0),
                'peluru' => max($player->peluru + $peluru_reward, 0),
            ]);

            \App\Models\Log::create([
                'player_id' => $player->id,
                'desc' => "[Super SI] Menambahkan <strong>{$honor_reward}</strong> honor dan <strong>{$peluru_reward}</strong> peluru untuk pos <strong>{$rallyGame->name}</strong>"
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

            $oldPoints = $oldPoint->honor_reward;
            $newPoints = $newPoint->honor_reward;

            $team = $player->team;

            $score->update([
                'point_id' => $newPoint->id
            ]);

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

            \App\Models\Log::create([
                'player_id' => $player->id,
                'desc' => "[Super SI] Mengubah point pos <strong>" . $score->rallyGame->name . "</strong> dari <strong>{$oldPoints}</strong> menjadi <strong>{$newPoints}</strong>"
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

            // Reverse Player Currency
            $honor_reward = $point->honor_reward;
            $peluru_reward = $point->peluru_reward;

            $player->update([
                'honor' => max($player->honor - $honor_reward, 0),
                'peluru' => max($player->peluru - $peluru_reward, 0)
            ]);

            \App\Models\Log::create([
                'player_id' => $player->id,
                'desc' => "[Super SI] Menghapus point pos <strong>" . $score->rallyGame->name . "</strong> (sebelumnya <strong>{$point->honor_reward}</strong> point)"
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
