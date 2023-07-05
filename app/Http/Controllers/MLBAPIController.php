<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\HittingStats;
use Illuminate\Http\Request;
use App\Models\FieldingStats;
use App\Models\PitchingStats;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MLBAPIController extends Controller
{
    public function fetchAndSaveData($uuid)
    {
        $url = "https://api.theshow.com/apis/item.json?uuid={$uuid}";

        $response = Http::get($url);

        if ($response->ok()) {
            $data = $response->json();
            dd($data);


            // Save the hitting attributes
            $this->addHittingAndFieldingStats($uuid, $data);
            // Set other hitting attributes based on the response data
            $hitter = $data['is_hitter'];
            // Save the pitching attributes (if applicable)
            if (!$hitter) {
                $this->addPitchingStats($uuid, $data);
            }
        }
    }
    public function processPlayerData()
    {
        Player::select('id', 'UUID')->chunk(25, function ($players) {
            foreach ($players as $player) {
                $this->fetchAndSaveData($player->UUID);
            }
        });
    }
    public function storeItem(Request $request)
    {
        // Access the parsed data from the request
    }
    public function pullOnePlayer()
    {
        $player =  Player::find(1);
        dd($player);
        // $this->fetchAndSaveData($player->uuid);
    }
    protected $currentIndex = 0;

    public function moveToNextUUID()
    {
        $this->currentIndex++;
        // Perform any necessary logic to move to the next UUID
        // ...
    }
    public function addHittingAndFieldingStats($uuid, array $item)
    {

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
        $contact_left = $item['contact_left'];
        $contact_right = $item['contact_right'];
        $power_left = $item['power_left'];
        $power_right = $item['power_right'];
        $batting_clutch = $item['batting_clutch'];
        $plate_vision = $item['plate_vision'];
        $plate_discipline = $item['plate_discipline'];
        $batting_clutch = $item['batting_clutch'];
        $bunting = $item['bunting_ability'];
        $drag = $item['drag_bunting_ability'];
    }

    public function addPitchingStats($uuid, array $item)
    {
        $pitchingStats = [
            "uuid" => $uuid,
            "stamina" => $item['stamina'],
            "pitching_clutch" => $item['pitching_clutch'],
            "hits_per_bf" => $item['hits_per_bf'],
            "k_per_bf" => $item['k_per_bf'],
            "bb_per_bf" => $item['bb_per_bf'],
            "hr_per_bf" => $item['hr_per_bf'],
            "pitch_velocity" => $item['pitch_velocity'],
            "pitch_control" => $item['pitch_control'],
            "pitch_movement" => $item['pitch_movement'],
        ];
        $pitches = $item['pitches'];
    }







    public function storeRosterUpdate(Request $request)
    {
    }
}
