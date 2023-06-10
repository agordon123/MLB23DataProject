<?php

namespace App\Console\Commands;

use App\Jobs\AddHittingAndFieldingStats;
use App\Jobs\AddPitchingStats;
use App\Jobs\AddPlayerStatsJob;
use App\Models\Item;
use App\Models\Player;
use App\Jobs\ProcessItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class AddStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-stats';

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
                
                AddHittingAndFieldingStats::dispatch($uuid);
            }
         //   $batch = Bus::dispatchToQueue(array_map(function ($uuid) {
      //          return new AddPitchingStats($uuid);
       //     }, $uuids));
        }
    }
}
