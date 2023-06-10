<?php

namespace App\Console\Commands\HTTPGet;

use App\Jobs\AddHittingAndFieldingStats;
use App\Jobs\ParseDataJob;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GetDataFromMLB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes argument of type to pull data from the MLB23 The Show APi and saves it to JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //type can be item, items, listing,listings,meta_data,roster_update_roster_updates

        $response = Http::get('https://mlb23.theshow.com/apis/roster_update.json?id=7');
        $data = $response->json();


        $newlyAdded = $data['newly_added'];
        

        if (isset($dataJson['newly_added'])) {

            $newlyAdded = $dataJson['newly_added'];


            $uuids = []; // Initialize the array outside the loop

            foreach ($newlyAdded as $items) {
                $uuid  = $items['obfuscated_id'];
                $uuids[] = $uuid; // Add each uuid to the array
            }

            // Dispatch the batch outside the loop, after all uuids have been added to the array
            $batch = Bus::batch(array_map(function ($uuid) {
                return new AddHittingAndFieldingStats($uuid);
            }, $uuids))->dispatch();
        }
    }
}
