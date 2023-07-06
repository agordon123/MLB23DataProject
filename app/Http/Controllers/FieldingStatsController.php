<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\FieldingStats;
use App\Http\Controllers\Controller;
use App\Models\HittingStats;
use Illuminate\Support\Facades\Validator;

class FieldingStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'player_id' => 'required',
            'baserunning_ability' => 'required',
            'baserunning_aggression' => 'required',
            'fielding_ability' => 'required',
            'fielding_durability' => 'required',
            'arm_accuracy' => 'required',
            'arm_strength' => 'required',
            'reaction_time' => 'required',
            'blocking' => 'required',
            'speed' => 'required',
            'hitting_durability' => 'required'
        ]);
        if ($validated) {
            $uuid = $request['uuid'];
            $baserunning_ability = $request['baserunning_ability'];
            $baserunning_aggression = $request['baserunning_aggression'];
            $fielding_ability = $request['fielding_ability'];
            $durability = $request['fielding_durability'];
            $armAcc = $request['arm_accuracy'];
            $armStrength = $request['arm_strength'];
            $reaction = $request['reaction_time'];
            $blocking = $request['blocking'];
            $speed = $request['speed'];
            $hitting_durability = $request['hitting_durability'];
            $playerId = Player::byUUID($uuid)->first()->only('id');
            $newStats = new FieldingStats([
                'player_id' => $playerId, 'blocking' => $blocking, 'reaction_time' => $reaction, 'arm_accuracy' => $armAcc, 'arm_strength' => $armStrength,
                'hitting_durability' => $hitting_durability, 'fielding_durability' => $durability, 'fielding_ability' => $fielding_ability,
                'baserunning_ability' => $baserunning_ability, 'baserunning_aggression' => $baserunning_aggression, 'speed' => $speed
            ]);
            $newStats->save();
        } else {
            return response()->json(['message' => 'Fielding Stats not added to' . $request->uuid . 'successfully'], 201);
        }

        return response()->json(['message' => 'Fielding Stats added to' . $uuid . 'successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = HittingStats::findOrFail($id)->first();
        return response()->json(['message' => 'Fielding Stats for' . $id . 'successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
