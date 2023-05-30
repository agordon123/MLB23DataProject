<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Pitch;
use App\Models\Player;
use App\Models\Pitcher;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseJsonFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:items';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse items.json file and store Items in the database';
    protected $item;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Read the contents of items.json


        $directory = 'public/';
        $filename = 'items';


        $itemsJson = Storage::get($directory . $filename . '.json');
        $data = json_decode($itemsJson, true);
        // Parse the JSON data
     
        // Loop through each item and store in the database as an item first
        foreach ($data as $item) {
            $newPlayerTableEntry = new Item();
            $newPlayer = new Player();
            $newPitcher = new Pitcher();
            $team = Team::searchByName($item['team'])->get()->only(['team_name', 'id']);
            $newPlayerTableEntry->uuid =  $item['uuid'];
            $newPlayerTableEntry->type =  $item['type'];
            $newPlayerTableEntry->rarity =  $item['rarity'];
            $newPlayerTableEntry->team =  $team->team_name;
            if ($item->is_hitter == false) {

                Artisan::call('data:parse-pitchers');
                $newPitcher->pitching_clutch = $item['pitching_clutch'];
                $newPitcher->hits_per_bf = $item['hits_per_bf'];
                $newPitcher->k_per_bf = $item['k_per_bf'];
                $newPitcher->bb_per_bf = $item['bb_per_bf'];
                $newPitcher->pitch_velocity = $item['pitch_velocity'];
                $newPitcher->pitch_control = $item['pitch_control'];
                $newPitcher->pitch_movement = $item['pitch_movement'];
                // need to save new player before extracting pivot table values
                foreach($item['pitches'] as $playerPitches){

                }
            }
            if ($item->is_hitter == true) {

                $newPlayer->uuid = $item['uuid'];
                $newPlayer->type = $item['type'];
                $newPlayer->rarity = $item['rarity'];
                $newPlayer->team = $item['team'];
                $newPlayer->ovr = $item['ovr'];
                $newPlayer->age = $item['age'];
                $newPlayer->height = $item['height'];
                $newPlayer->weight = $item['weight'];
                $newPlayer->bat_hand = $item['bat_hand'];
                $newPlayer->display_position = $item['display_position'];
                $newPlayer->display_secondary_positions = $item['display_secondary_positions'];
                $newPlayer->is_hitter = $item['is_hitter'];
                $newPlayer->contact_left = $item['contact_left'];
                $newPlayer->contact_right = $item['contact_right'];
                $newPlayer->power_left = $item['power_left'];
                $newPlayer->power_right = $item['power_right'];
                $newPlayer->plate_vision = $item['plate_vision'];
                $newPlayer->plate_discipline = $item['plate_discipline'];
                $newPlayer->batting_clutch = $item['batting_clutch'];
                $newPlayer->bunting_ability = $item['bunting_ability'];
                $newPlayer->baserunning_ability = $item['baserunning_ability'];
                $newPlayer->baserunning_aggression = $item['baserunning_aggression'];;
                $newPlayer->save();
                $this->info($newPlayer);
            }






            $pitcher = Pitcher::firstOrCreate([
                'name' => $item['pitcher_name'],
            ]);
        }


        // Create the Pitch
        $pitch = $pitcher->pitches()->create([
            'name' => $item['pitch_name'],
            // Assign other pitch-specific attributes
        ]);

        //  Create the PitchAttributes for the Pitch
        $pitch->attributes()->create([
            'speed' => $item['speed'],
            'control' => $item['control'],
            'break' => $item['break'],
            // Assign other pitch attribute values
        ]);
    }
}
