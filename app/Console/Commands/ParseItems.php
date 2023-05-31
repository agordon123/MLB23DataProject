<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Player;
use App\Models\PitchingStats;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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

        $page = $this->argument('page');
        $directory = 'public/';
        $filename = 'items';


        $itemsJson = Storage::get($directory . $filename .$page. '.json');
        $data = json_decode($itemsJson, true);


        // Loop through each item and store in the database as an item first
        foreach ($data as $item) {
            $newPlayerTableEntry = new Item();
            $newPlayer = new Player();
            $newPitcher = new PitchingStats();
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
                foreach ($item['pitches'] as $playerPitches) {
                }
            }

        }
    }
}
