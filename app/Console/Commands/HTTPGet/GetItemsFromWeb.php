<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GetItemsFromWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:items';

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

        //this for loop creates a json file for every page of mlb_cards from theshow.com and stores it in storage/app/public/json

        $directory = 'public/json/roster_update/';

        $jsonFilePath = Storage::get($directory . 'roster_update7.json');

        $dataJson = json_decode($jsonFilePath, true);
        if (isset($dataJson['newly_added'])) {

            $newlyAdded = $dataJson['newly_added'];

            foreach ($newlyAdded as $items) {
                $uuid  = $items['obfuscated_id'];
                $newPlayer = Http::get("https://mlb23.theshow.com/apis/item.json?uuid={$uuid}");
                $data = $newPlayer->json();
                $jsonData = json_encode($data);
                Storage::put("public/json/newly_added/{$uuid}.json", $jsonData);

            }
        }
      /*  $uuid = $this->argument();
            $url = "https://mlb23.theshow.com/apis/items?uuid={$uuid}.json";

            $itemsJson = Http::get($url);
            $data = $itemsJson->json();
            $jsonData = json_encode($data);
            Storage::put("public/json/items.json", $jsonData);

*/
    }
}
