<?php

namespace App\Console\Commands;


use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MLBAPIController;

class FetchMLBDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:items-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls data from theshow.com and sends it through the controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //type can be item, items, listing,listings,meta_data,roster_update_roster_updates

        $types = ['roster_update', 'items', 'listings', 'meta_data'];


        foreach ($types as $type) {
            if ($type == 'items') {
                for ($i = 1; $i <= 107; $i++){
                    $url = "https://mlb23.theshow.com/apis/{$type}?type=mlb_card?page={$i}.json";
                    $data = file_get_contents($url);
                    $dataJson = json_decode($data, true);
                    $jsonData = json_encode($dataJson, JSON_PRETTY_PRINT);
                    $filename = "data_{$type}_page{$i}.json";

                    Storage::put('public/json/'.$filename, $jsonData);

                }

            }
            /*     if ($type == 'roster_update') {
                for ($i = 1; $i <= 7; $i++) {
                    $url = "https://mlb23.theshow.com/apis/{$type}?id={$i}.json";
                    $data = file_get_contents($url);
                    $dataJson = json_decode($data, true);
                    $apiController = new MLBAPIController();
                    $apiController->storeData(new Request(['storeData' => $dataJson, 'type' => $type]));

            $quirks = $data['quirks'];
            $pitches = $data['pitches'];
                }
                        $directoryPath = '/public/json/newly_added/';
        $jsonFilePaths = Storage::allFiles($directoryPath);

        $uuids = array_map(function ($filePath) {
            return pathinfo($filePath, PATHINFO_FILENAME);
        }, $jsonFilePaths);

        foreach ($uuids as $uuid) {
            ParseDataJob::dispatch($uuid);
        }
            }*/
        }
        $this->info('Successful');
    }
}
