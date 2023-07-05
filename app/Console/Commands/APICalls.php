<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class APICalls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:calls {type}';

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
        $client = new Client();
        $option = $this->argument('type');
        if ($option == 'roster_updates') {
            $api = 'roster_updates';
            $response =  $client->get("https://mlb23.theshow.com/apis/" . $api . '.json?type=mlb_card');
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if ($option == 'items') {
            for ($i = 1; $i <= 116; $i++) {
                $url = "https://mlb23.theshow.com/apis/{$option}?type=mlb_card?page={$i}.json";
                $data = file_get_contents($url);
                $dataJson = json_decode($data, true);
                $jsonData = json_encode($dataJson, JSON_PRETTY_PRINT);
                $filename = "data_{$option}_page{$i}.json";
                Storage::put('public/json/' . $filename, $jsonData);
            }
        }
        if ($option == 'roster_update') {
            $api = 'roster_update';
            $id = $this->argument('id');
            $response =   $client->get("https://mlb23.theshow.com/apis/" . $api . '?id=' . $id);
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if ($option == 'item') {
            $api = $option;
            $uuid = $this->argument('uuid');
            $response =  $client->get("https://mlb23.theshow.com/apis/" . $api . '.json?uuid=' . $uuid);
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if ($option == 'listings') {
            $api = $option;
            $response = $client->get("https://mlb23.theshow.com/apis/" . $api . '.json?type="mlb_card');
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if ($option == 'listing') {
            $api = $option;
            $uuid = $this->argument('uuid');
            $response = $client->get("https://mlb23.theshow.com/apis/" . $api . '.json?uuid=' . $uuid);
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if ($option == 'meta_data') {
            $api = $option;
            $response = $client->get("https://mlb23.theshow.com/apis/" . $api . '.json');
            $data = $response;
            $file = json_encode($data, JSON_PRETTY_PRINT);
            Storage::put('public/json/ex/' . $api . '.json', $file);
        }
        if($option == 'team'){
            $api = 'items';
            $response = $client->get("https://mlb23.theshow.com/apis/" . $api . '.json?type=mlb_card&page=1');
            $data = $response->getBody();
          
            $file = json_decode($data, true);
            foreach($file as $dataItem){
                $uuid = $dataItem['uuid'];
                $response = $client->get("https://mlb23.theshow.com/apis/item.json?uuid=" . $uuid);
                $data = $response->getBody();
                $file = json_encode($data, JSON_PRETTY_PRINT);
                Storage::put('public/json/ex/' . $api . '.json', $file);
            }
        }
    }
}
