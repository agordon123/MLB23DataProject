<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\Player;
use App\Rules\IsHitterTrue;
use App\Rules\IsHitterFalse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::all();
        return PlayerResource::collection($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeHitter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item_id'=>'required|integer',
            'quirks'=>'sometimes|array',
            'ovr'=>'required|integer',
            'age'=>'required|integer',
            'height'=>'required|string',
            'weight'=>'required|integer',
            'bat_hand'=>'required|string',
            'throw_hand'=>'required|string',
            'is_hitter' => ['required', 'boolean', new IsHitterTrue]

        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), 400
            ]);
        };
        $player = new Player();




        return (new PlayerResource($player))->response()->setStatusCode(201);
    }
    public function storePitcher(Request $request){
        $validated = Validator::make($request->all(), [
            'item_id' => 'sometimes|integer',
            'uuid'=>'required|string',
            'quirks' => 'sometimes|array',
            'ovr' => 'required|integer',
            'age' => 'required|integer',
            'height' => 'required|string',
            'weight' => 'required|integer',
            'bat_hand' => 'required|string',
            'throw_hand' => 'required|string',
            'is_hitter' => ['required', 'boolean', new IsHitterFalse]
        ]);
        $player = new Player(
            [

            ]
        );
        if (!$player->is_hitter) {
            $player->pitcher_stats = [
                'pitching_clutch' => $request->pitching,
                'hits_per_bf' => 0,
                // Add other pitcher stats attributes with default values
            ];
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $player = Player::with('quirks','player_hitting_stats','player_fielding_stats')
        ->whenHas('pitching_stats', function ($query) {
            $query->with('pitches','pitching_stats');
        })->find($id);

        return (new PlayerResource($player))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $validated = Validator::make($request->all(),[

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player = Player::find($player->id);
        $player->delete();
        return response()->json(['data' => 'Item Deleted'], 204);
    }
}
