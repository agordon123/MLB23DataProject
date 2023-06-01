<?php

namespace App\Console\Commands;

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



        for ($i = 1; $i <= 106; $i++) {
            $url = "https://mlb23.theshow.com/apis/items.json?type=mlb_card&page={$i}";
            $itemsJson = Http::get($url);
            $data = $itemsJson->json();
            $jsonData = json_encode($data);
            Storage::put("public/json/items{$i}.json", $jsonData);

        }
    }
}
