<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PitcherResource;
use App\Models\Pitcher;
use Illuminate\Support\Facades\Validator;

class PitcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pitchers = Pitcher::all();
        return PitcherResource::collection($pitchers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'player_id' => 'required',
            'pitches' => 'required|array',
            'pitching_clutch' => 'required',
            'hits_per_bf' => 'required',
            'k_per_bf' => 'required',
            'bb_per_bf' => 'required',
            'pitch_velocity' => 'required',
            'pitch_control' => 'required',
            'pitch_movement' => 'required'
        ]);
        if ($validated) {
            $pitcher = new Pitcher();
            foreach($request->all() as $item){

            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pitcher = Pitcher::findOrFail($id);
        if($pitcher == null){
            return response()->json([],400);
        }
        return response()->json(new PitcherResource($pitcher),200);
    }
    /**
     * syncPitches
     *
     */
    public function syncPitches(Player $player, Pitch $pitch)
    {
        
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
