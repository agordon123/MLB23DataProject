<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchMLBDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:data-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks every MLB 23 API endpoint for data and updates the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //type can be item, items, listing,listings,meta_data,roster_update_roster_updates
        $type = $this->argument('type');
        $types = ['items','listings','meta_data','roster_update'];
        $dateTimeString = Carbon::now()->format('Y-m-d_H-i-s');
        $url = "https://mlb23.theshow.com/apis/{$type}.json";

        $itemsJson = Http::get($url);
        $data = $itemsJson->json();
        $jsonData = json_encode($data);
        for ($i = 1; $i <= 106; $i++) {
        }
        Storage::put("public/json/{$type}/{$type}-{$dateTimeString}.json", $jsonData);
    }
}
