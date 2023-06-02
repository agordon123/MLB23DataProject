<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerResource;
use App\Models\Pitch;


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
    public function store(Request $request)
    {
        $player = new Player();
        $player->is_hitter = false;
        if (!$player->is_hitter) {
            $player->pitcher_stats = [
                'pitching_clutch' => 0,
                'hits_per_bf' => 0,
                // Add other pitcher stats attributes with default values
            ];
        }
        $player->save();

        return (new PlayerResource($player))->response()->setStatusCode(201);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
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
