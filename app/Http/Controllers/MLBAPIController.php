<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Item;
use App\Models\Team;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use App\Models\Series;
use Illuminate\Log\Logger;

use App\Models\HittingStats;
use Illuminate\Http\Request;
use App\Models\PitchingStats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FieldingStats;
use Illuminate\Support\Facades\Validator;

class MLBAPIController extends Controller
{
    public function getCurrentData(Request $request)
    {
    }
    public function storeItem(Request $request)
    {
        // Access the parsed data from the request
        $data = $request->input('parsedData');
        $type = $request->input('type');

        $existingUuids = Item::pluck('uuid')->toArray();

        if (!$type == 'items') {
            return;
        } else {
            foreach ($data['items'] as $item) {
                if (in_array($item['uuid'], $existingUuids)) {
                    // The UUID already exists in the DB
                    Logger('The UUID already exists in the DB: ' . $item['uuid']);
                    continue;
                }
                $series = Series::where('name', $item['series'])->first();

                $team = Team::where('name', $item['team'])->first();
                $newItem = Item::create([
                    'uuid' => $item['uuid'],
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'rarity' => $item['rarity'],
                    'img' => $item['img'],
                    'baked_img' => $item['baked_img'],
                    'series_id' => $series->id,
                    'team' => $team->name
                ]);

                if ($item['type'] == 'mlb_card') {


                    $player = Player::create([
                        'item_id' => $newItem->id,
                        'ovr' => $item['ovr'],
                        'age' => $item['age'],
                        'height' => $item['height'],
                        'weight' => $item['weight'],
                        'bat_hand' => $item['bat_hand'],
                        'throw_hand' => $item['throw_hand'],
                        'is_hitter' => $item['is_hitter'],
                    ]);

                    $newItem->player()->associate($player);
                    $newItem->series()->associate($series);
                    $newItem->team()->associate($team);
                    $newItem->save();

                    if ($item['is_hitter']) {
                        $hittingStats = HittingStats::create([
                            "contact_left" => $item['contact_left'],
                            "contact_right" => $item['contact_right'],
                            "power_left" => $item['power_left'],
                            "power_right" => $item['power_right'],
                            "plate_vision" => $item['plate_vision'],
                            "plate_discipline" => $item['plate_discipline'],
                            "batting_clutch" => $item['batting_clutch'],
                            "bunting_ability" => $item['bunting_ability'],
                            "drag_bunting_ability" => $item['drag_bunting_ability'],
                        ]);
                        $player->hittingStats()->save($hittingStats);
                        $quirks = $item['quirks'];
                        foreach ($quirks as $item) {
                            $uuid = $item['uuid'];
                            $quirks = $item['quirks'];
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
                            "stamina" => $item['stamina'],
                            "pitching_clutch" => $item['pitching_clutch'],
                            "hits_per_bf" => $item['hits_per_bf'],
                            "k_per_bf" => $item['k_per_bf'],
                            "bb_per_bf" => $item['bb_per_bf'],
                            "hr_per_bf" => $item['hr_per_bf'],
                            "pitch_velocity" => $item['pitch_velocity'],
                            "pitch_control" => $item['pitch_control'],
                            "pitch_movement" => $item['pitch_movement'],
                        ]);
                        $pitches = $item['pitches'];
                        $quirks = $item['quirks'];

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
            }


            return response()->json(['message' => 'Data stored successfully']);
        }
    }
    public function storeRosterUpdate(Request $request)
    {
        $data = $request->input('parsedData');
        $type = $request->input('type');
        if ($type == 'roster_update') {
            foreach ($data as $key => $value) {
                if ($data[$key] == 'attribute_changes') {
                    $uuid = $data['obfuscated_id'];
                    $itemCheck = Item::where('uuid', $uuid)->first();
                    if ($itemCheck != $uuid) {
                        dd($data);
                    }
                }
            }
        }
        // Store the data in the database using appropriate models and logic
        // Example: Use the desired model and store the data
        // YourModel::create($parsedData);

        // Perform any additional processing or validation as needed

        // Return a response or perform any other actions
    }
    public function addStatsToUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player' => 'required|App\Models\Player',
            'quirks' => 'sometimes|array',

            'hitting_stats' => 'required|array',
            'fielding_stats' => 'required|array',

        ]);
        if ($validator->fails()) {
            return $this->info('Validation failed with errors : ', $validator->errors());
        }
        $player = $request->input('player');
        $quirks = $request->input('quirks');
        $hittingStats = $request->input('hitting_stats');
        $fieldingStats = $request->input('fielding_stats');

        foreach ($hittingStats as $item) {

            $id = $player->id;
            $contact_left = $item['contact_left'];
            $contact_right = $item['contact_right'];
            $power_left = $item['power_left'];
            $power_right = $item['power_right'];
            $plate_vision = $item['plate_vision'];
            $plate_discipline = $item['plate_discipline'];
            $batting_clutch = $item['batting_clutch'];
            $bunting_ability = $item['bunting_ability'];
            $drag_bunting_ability = $item['drag_bunting_ability'];
            if ($player) {

                $hittingStats = new HittingStats(['player_id' => $id,]);
                $hittingStats->contact_left = $contact_left;
                $hittingStats->contact_right = $contact_right;
                $hittingStats->power_left = $power_left;
                $hittingStats->power_right = $power_right;
                $hittingStats->plate_vision = $plate_vision;
                $hittingStats->plate_discipline = $plate_discipline;
                $hittingStats->batting_clutch = $batting_clutch;
                $hittingStats->bunting_ability = $bunting_ability;
                $hittingStats->drag_bunting_ability = $drag_bunting_ability;


                try {
                    DB::beginTransaction();

                    $hittingStats->save();
                    DB::commit();
                    DB::afterCommit($this->info($player->uuid . ' Saved, Player ID: ' . $player->id));
                } catch (Exception $e) {
                    DB::rollback();
                    $this->info($e);
                }
            } else {
                $this->info($player . ' Not Found');
            }
        }
        foreach ($fieldingStats as $item) {
            $newStats = new FieldingStats(['player_id' => $id]);
            $baserunning_ability = $item['baserunning_ability'];
            $baserunning_aggression = $item['baserunning_aggression'];
            $fielding_ability = $item['fielding_ability'];
            $durability = $item['fielding_durability'];
            $armAcc = $item['arm_accuracy'];
            $armStrength = $item['arm_strength'];
            $reaction = $item['reaction_time'];
            $blocking = $item['blocking'];
            $speed = $item['speed'];
            $hitting_durability = $item['hitting_durability'];
            $newStats->baserunning_ability = $baserunning_ability;
            $newStats->baserunning_aggression = $baserunning_aggression;
            $newStats->fielding_ability = $fielding_ability;
            $newStats->fielding_durability = $durability;
            $newStats->arm_accuracy = $armAcc;
            $newStats->arm_strength = $armStrength;
            $newStats->reaction = $reaction;
            $newStats->blocking = $blocking;
            $newStats->speed = $speed;
            $newStats->hitting_durability = $hitting_durability;
            try {
                DB::beginTransaction();

                $hittingStats->save();
                DB::commit();
                DB::afterCommit($this->info($player->uuid . ' Saved, Player ID: ' . $player->id));
            } catch (Exception $e) {
                DB::rollback();
                $this->info($e);
            }
        }
        $this->info($player . ' Not Found');



        foreach ($quirks as $quirkData) {
            $quirkName = $quirkData['name'];
            $dbQuirk = Quirk::byName($quirkName)->first();
            if ($dbQuirk) {
                $player->quirks()->attach($dbQuirk->id);
            }
        }

        return response()->json([], 200);
    }
}
