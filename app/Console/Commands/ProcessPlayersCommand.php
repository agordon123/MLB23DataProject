<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;
use App\Http\Controllers\MLBAPIController;

class ProcessPlayersCommand extends Command
{
    protected $signature = 'players:process {page : page to start from }';

    protected $description = 'Process player data';

    public function handle()
    {
        $startPage = $this->argument('page');

        for ($page = $startPage; $page < 117; $page++) {
            //  $url = "https://mlb23.theshow.com/apis/items.json?type=mlb_card&page={$page}";
            //
            //
            //
            //  $itemsJson = Http::get($url);
            //  $data = $itemsJson->json();


            $filePath = storage_path("app/public/json/items{$page}.json");
            $data = file_get_contents($filePath);
            $dataJson = json_decode($data, true);

            $itemChunks = array_chunk($dataJson['items'], 100, true); // Adjust the chunk size as needed

            foreach ($itemChunks as $items) {
                $uuids = array_column($items, 'uuid');


                foreach ($items as $item) {
                    $uuid = $item['uuid'];

                    try {
                        $this->addSeriesYear($uuid, $item);


                        echo ($uuid . ' saved');
                    } catch (\Throwable $th) {
                        echo ($th);
                    }
                }
            }
        }

        unset($data);

        $this->info('Page ' . $page . ' saved');
    }
    public function addSeriesYear($uuid, $item)
    {
        $series = $item['series_year'];

        $player = Player::byUUID($uuid)->first();
        $player->series_year = $series;
        $player->save();
        echo ($player->name . ' saved as series year' . $player->series_year);
    }
}
