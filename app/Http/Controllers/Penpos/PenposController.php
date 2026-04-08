<?php

namespace App\Http\Controllers\Penpos;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Team;
use App\Models\Point;
use App\Models\Relic;
use App\Models\Score;
use App\Models\Player;
use App\Events\InformSI;
use App\Models\Inventory;
use App\Models\RallyGame;
use App\Models\RelicChosen;
use App\Models\Notification;
use App\Models\RelicMission;
use Illuminate\Http\Request;
use App\Models\GameBesarSession;
use Illuminate\Support\Facades\DB;
use App\Events\UpdateAvailableStock;
use App\Http\Controllers\Controller;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Support\Facades\Auth;
use App\Events\UpdateTearsSemiPrivate;

class PenposController extends Controller
{
    public function index()
    {
        $points = Point::where('type', Auth::user()->rallyGame->type)->get();
        $scores = Score::where('rally_game_id', Auth::user()->rallyGame->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $relics = Relic::all();

        $session = GameBesarSession::where('open', '<=', Carbon::now())
                    ->where('close', '>=', Carbon::now())
                    ->first();
        
        if (!$session) {
            $relicsInMission = null;
            return view('penpos.index', compact('points', 'scores', 'relics', 'relicsInMission'));
        }

        $relicsInMission = RelicMission::select("relic_missions.mission_id", "relic_missions.relic_id", "relic_missions.qty")
            ->join("missions", "missions.id", "=", "relic_missions.mission_id")
            ->join("game_besar_sessions", "game_besar_sessions.mission_id", "=", "missions.id");

        if ($session) {
            $relicsInMission = $relicsInMission->where("game_besar_sessions.id", "=", $session->id)->get();
        } else {
            $relicsInMission = $relicsInMission->get();
        }

        return view('penpos.index', compact('points', 'scores', 'relics', 'relicsInMission'));
    }

    public function updateStock(Request $request)
    {
        event(new UpdateAvailableStock());
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tim' => ['required'],
            'point_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $msg = 'NO';

            // Cari Player dan Point (Cari tim dlu baru player)
            $team = Team::where('name', $request->get('tim'))->first();
            $player = Player::where('team_id', $team->id)->first();
            $point = Point::find($request->get('point_id'));

            $desc = "Berhasil menambahkan poin ke Tim " . $team->name;
            
            // Cek Apakah Tim sudah pernah main (udah ada poin-nya), klo iya langsung return aja
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

            $relicRequests = $request->input('relics', []); // struktur: ['red' => 2, 'blue' => 1, ...]
            $redRelicRequest = $relicRequests['red'] ?? 0;
            $blueRelicRequest = $relicRequests['blue'] ?? 0;
            $purpleRelicRequest = $relicRequests['purple'] ?? 0;

            // Check if relic request not above the limit
            $relicQtyRequest = $redRelicRequest + $blueRelicRequest + $purpleRelicRequest;
            $relicQtyGiven = $point->relic_qty;

            if ($relicQtyGiven < $relicQtyRequest) {
                $msg = "YES";
                return response()->json([
                    'msg' => 'YES',
                    'error_code' => 'RELIC_OVER_LIMIT',
                    'error_message' => 'Jumlah relic yang diminta melebihi batas.',
                ], 400);
            }

            $points = $point->point;

            $gameBesarSession = null;
            
            if ($points > 0) {
                $gameBesarSession = GameBesarSession::where('open', '<=', Carbon::now())
                        ->where('close', '>=', Carbon::now())
                        ->first();
    
                // Check if game besar session is active
                if (!$gameBesarSession) {
                    return response()->json([
                        'error_code' => 'SESSION_NOT_FOUND',
                        'error_message' => '[HUBUNGI SI] Sesi GameBesar tidak ditemukan atau belum aktif.',
                    ], 404);
                }
                
                // Check if relic stock is enough
                if (
                    $redRelicRequest > $gameBesarSession->red_relic_stock ||
                    $blueRelicRequest > $gameBesarSession->blue_relic_stock ||
                    $purpleRelicRequest > $gameBesarSession->purple_relic_stock
                ) {
                    return response()->json([
                        'msg' => 'YES',
                        'error_code' => 'RELIC_STOCK_NOT_AVAILABLE',
                        'error_message' => 'Stok relic tidak mencukupi untuk salah satu warna.',
                    ], 400);
                }
            }

            // Create Score
            $score = Score::create([
                'rally_game_id' => Auth::user()->rallyGame->id,
                'player_id' => $player->id,
                'point_id' => $point->id
            ]);
            
            // Create Relic Chosen
            $relicChosen = RelicChosen::create([
                'score_id' => $score->id,
                'red_relic_qty' => $redRelicRequest,
                'blue_relic_qty' => $blueRelicRequest,
                'purple_relic_qty' => $purpleRelicRequest,
            ]);

            // Give Relics
            $relicModels = Relic::all()->keyBy('color');
            foreach ($relicRequests as $color => $qty) {
                if ($qty > 0 && isset($relicModels[$color])) {
                    Inventory::where('player_id', $player->id)
                        ->where('relic_id', $relicModels[$color]->id)
                        ->increment('qty', $qty);
                }
            }

            // Update Tears
            $player->update([
                'tears' => $player->tears + $points,
            ]);

            // Reduce relic stock
            if ($points > 0) {
                $gameBesarSession->decrement('red_relic_stock', $redRelicRequest);
                $gameBesarSession->decrement('blue_relic_stock', $blueRelicRequest);
                $gameBesarSession->decrement('purple_relic_stock', $purpleRelicRequest);
            }

            // Fire events
            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());
            
            $scores = RallyGame::getPenposScores(Auth::user()->rallyGame->id);

            DB::commit();
            
            return response()->json([
                'msg' => 'NO',
                'point' => $point,
                'team' => $team,
                'scores' => $scores,
                'desc' => 'Berhasil menambahkan poin ke Tim ' . $team->name,
                'relic_chosen' => $relicChosen
            ], 200);

        } catch (\Exception $x) {
            DB::rollBack();
            return response()->json([
                'msg' => 'ERROR',
                'error_code' => 'SERVER_EXCEPTION',
                'error_message' => "[HUBUNGI SI]" . $x->getMessage()
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

            // Update Tears
            $points = $score->point->point;
            $newTears = max($player->tears - $points, 0); // cap at 0
            $player->update(['tears' => $newTears]);

            // Get Relic Chosen record
            $relicChosen = RelicChosen::where('score_id', $score->id)->first();

            if ($relicChosen) {
                // Reduce Inventory (player's relics)
                $relicModels = Relic::all()->keyBy('color');

                $relicMap = [
                    'red' => $relicChosen->red_relic_qty,
                    'blue' => $relicChosen->blue_relic_qty,
                    'purple' => $relicChosen->purple_relic_qty,
                ];

                foreach ($relicMap as $color => $qty) {
                    if ($qty > 0 && isset($relicModels[$color])) {
                        Inventory::where('player_id', $player->id)
                            ->where('relic_id', $relicModels[$color]->id)
                            ->decrement('qty', $qty);
                    }
                }

                // Add back to stock in current session
                $gameBesarSession = GameBesarSession::where('open', '<=', Carbon::now())
                    ->where('close', '>=', Carbon::now())
                    ->first();

                if ($gameBesarSession) {
                    $gameBesarSession->increment('red_relic_stock', $relicMap['red']);
                    $gameBesarSession->increment('blue_relic_stock', $relicMap['blue']);
                    $gameBesarSession->increment('purple_relic_stock', $relicMap['purple']);
                }

                // Delete relic chosen record
                $relicChosen->delete();
            }
            
            // Delete score
            $score->delete();

            // Refresh scores
            $scores = RallyGame::getPenposScores($rallyGame->id);

            // Fire events
            event(new UpdateTearsSemiPrivate($player->id));
            event(new UpdateAvailableStock());

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

    public function getPlayerInventory(Request $request)
    {
        $team = Team::where('name', $request->team_name)->first();
        $player = Player::where('team_id', $team->id)->first();

        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        $inventory = $player->inventory()->with('relic')->get(['relic_id', 'qty']);

        $formattedInventory = [
            [
                'relic_id' => 1,
                'nama' => $inventory->firstWhere('relic_id', 1)->relic->nama,
                'color' => 'red',
                'qty' => $inventory->firstWhere('relic_id', 1)->qty ?? 0,
            ],
            [
                'relic_id' => 2,
                'nama' => $inventory->firstWhere('relic_id', 2)->relic->nama,
                'color' => 'purple',
                'qty' => $inventory->firstWhere('relic_id', 2)->qty ?? 0,
            ],
            [
                'relic_id' => 3,
                'nama' => $inventory->firstWhere('relic_id', 3)->relic->nama,
                'color' => 'blue',
                'qty' => $inventory->firstWhere('relic_id', 3)->qty ?? 0,
            ],
        ];

        return response()->json([
            'player' => $player,
            'inventory' => $formattedInventory
        ]);
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
