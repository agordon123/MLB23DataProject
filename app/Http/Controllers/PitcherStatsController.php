<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Pitch;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\PitchingStats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PitcherStatsResource;

class PitcherStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pitchers = PitchingStats::all()->with(['player']);
        return PitcherStatsResource::collection($pitchers);
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
            $pitcher = new PitchingStats([]);
            foreach ($request->all() as $item) {
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pitcher = PitchingStats::findOrFail($id);
        if ($pitcher == null) {
            return response()->json([], 400);
        }
        return response()->json(new PitcherStatsResource($pitcher), 200);
    }
    /**
     * syncPitches
     *
     */
    public function syncPitches(Request $request)
    {
        $player = Player::findOrFail($request->player_id);
        $validated = Validator::make($request->all(), [
            'player_id' => 'required',
            'pitches' => 'required|array'
        ]);
        $pitches = $request->getContent(true);
        $pitches = json_decode($pitches, true);
        foreach ($pitches as $pitchData) {
            $name = $pitchData['name'];
            $speed = $pitchData['speed'];
            $control = $pitchData['control'];
            $break = $pitchData['movement'];

            $pitch = Pitch::where('name', $name)->first();
            if ($pitch) {
                try {
                    DB::beginTransaction();
                    $player->pitches()->attach($pitch->id, [
                        'speed' => $speed,
                        'control' => $control,
                        'movement' => $break
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $this->info($e);
                }
            }
        }
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
