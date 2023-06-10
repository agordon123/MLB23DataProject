<?php

namespace App\Http\Controllers;



use Exception;
use App\Models\Item;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use App\Rules\IsHitterTrue;
use App\Models\HittingStats;
use App\Rules\IsHitterFalse;
use Illuminate\Http\Request;
use App\Models\PitchingStats;
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
    public function storeHitter(Item $item,$data)
    {
        // $validator = Validator::make($request->all(),[
        //       'item_id'=>'required|integer',
        //       'quirks'=>'sometimes|array',
        //     'ovr'=>'required|integer',
        //       'age'=>'required|integer',
        //       'height'=>'required|string',
        //       'weight'=>'required|integer',
        //        'bat_hand'=>'required|string',
        //        'throw_hand'=>'required|string',
        //        'is_hitter' => ['required', 'boolean', new IsHitterTrue]
        //
        //       ]);
        //       if ($validator->fails()) {
        //         return response()->json([
        //             'errors' => $validator->errors(), 400
        //     ]);
        //  };
        if ($data['type'] == 'mlb_card') {


            $player = Player::create([
                'item_id' => $data->id,
                'ovr' => $data['ovr'],
                'age' => $data['age'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'bat_hand' => $data['bat_hand'],
                'throw_hand' => $data['throw_hand'],
                'is_hitter' => $data['is_hitter'],
            ]);

            $item->player()->associate($player);

            $item->save();

            if ($data['is_hitter']) {
                $hittingStats = HittingStats::create([
                    "contact_left" => $data['contact_left'],
                    "contact_right" => $data['contact_right'],
                    "power_left" => $data['power_left'],
                    "power_right" => $data['power_right'],
                    "plate_vision" => $data['plate_vision'],
                    "plate_discipline" => $data['plate_discipline'],
                    "batting_clutch" => $data['batting_clutch'],
                    "bunting_ability" => $data['bunting_ability'],
                    "drag_bunting_ability" => $data['drag_bunting_ability'],
                ]);
                $player->hittingStats()->save($hittingStats);
                $quirks = $data['quirks'];
                foreach ($quirks as $data) {
                    $uuid = $data['uuid'];
                    $quirks = $data['quirks'];
                    $player = Player::byUUID($uuid)->first();
                    foreach ($quirks as $quirkData) {
                        $quirkName = $quirkData['name'];
                        $dbQuirk = Quirk::byName($quirkName)->first();
                        if ($dbQuirk) {
                            $player->quirks()->attach($dbQuirk->id);
                        }
                    }
                }
            } else {
                $pitchingStats = PitchingStats::create([
                    "stamina" => $data['stamina'],
                    "pitching_clutch" => $data['pitching_clutch'],
                    "hits_per_bf" => $data['hits_per_bf'],
                    "k_per_bf" => $data['k_per_bf'],
                    "bb_per_bf" => $data['bb_per_bf'],
                    "hr_per_bf" => $data['hr_per_bf'],
                    "pitch_velocity" => $data['pitch_velocity'],
                    "pitch_control" => $data['pitch_control'],
                    "pitch_movement" => $data['pitch_movement'],
                ]);
                $pitches = $data['pitches'];
                $quirks = $data['quirks'];

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
                $player->pitchingStats()->save($pitchingStats);
            }
        }
        return (new PlayerResource($player))->response()->setStatusCode(201);
    }









    public function storePitcher(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'item_id' => 'sometimes|integer',
            'uuid' => 'required|string',
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
            []
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
        $player = Player::with('quirks', 'player_hitting_stats', 'player_fielding_stats')
            ->whenHas('pitching_stats', function ($query) {
                $query->with('pitches', 'pitching_stats');
            })->find($id);

        return (new PlayerResource($player))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        if ($request->player) {
            $uuid =   $player->item->uuid;
            $updatedModel = Player::byUUID($$uuid)->first();
        }
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
