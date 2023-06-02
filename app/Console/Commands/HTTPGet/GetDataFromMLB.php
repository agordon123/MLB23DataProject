<?php

namespace App\Console\Commands\HTTPGet;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GetDataFromMLB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data {type}';

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
        $type = $this->argument('type');
        $dateTimeString = Carbon::now()->format('Y-m-d_H-i-s');
        $url = "https://mlb23.theshow.com/apis/{$type}.json";
        $itemsJson = Http::get($url);
        $data = $itemsJson->json();
        $jsonData = json_encode($data);

        Storage::put("public/json/{$type}/{$type}-{$dateTimeString}.json", $jsonData);
    }
}
