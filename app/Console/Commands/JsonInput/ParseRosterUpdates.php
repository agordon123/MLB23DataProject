<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Item;
use App\Models\Team;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use App\Models\Series;
use App\Jobs\ProcessItem;
use App\Jobs\ParseDataJob;
use App\Jobs\CreateItemJob;
use Illuminate\Http\Request;
use App\Jobs\CreatePlayerJob;
use App\Models\PitchingStats;
use Illuminate\Bus\Batchable;
use Illuminate\Console\Command;
use App\Events\CreatePlayerEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MLBAPIController;
use App\Http\Controllers\PlayerController;

class ParseRosterUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $response = Http::get('https://mlb23.theshow.com/apis/roster_update.json?id=7');
        $data = $response->json();



      //  $attributeChange = $data['attribute_changes'];
        $newlyAdded = $data['newly_added'];
      //  $positionChange = $data['position_changes'];

        if (isset($data['newly_added'])) {

            $newlyAdded = $data['newly_added'];



            $uuids = []; // Initialize the array outside the loop

            foreach ($newlyAdded as $items) {
                $uuid  = $items['obfuscated_id'];
                $player = Player::where('uuid',$uuid);
                $uuids[] = $uuid; // Add each uuid to the array
            }

            // Dispatch the batch outside the loop, after all uuids have been added to the array
            $batch = Bus::batch(array_map(function ($uuid) {
                return new ProcessItem($uuid);
            }, $uuids))->dispatch();



        }
    }
}
