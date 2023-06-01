<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddTeamToItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:team';

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
        $directory = 'public/json/';
        $filename = 'items';

        for ($i = 1; $i <= 106; $i++){
            $itemsJson = Storage::get($directory . $filename . $i . '.json');
            $data = json_decode($itemsJson, true);
            foreach ($data['items'] as $item) {

                $uuid = $item['uuid'];
                $team = $item['team'];
                Item::where('uuid', $uuid)->update(['team' => $team]);
            }
        }



        // Loop through each item and store in the database as an item first
        //above code sets up items.json to parse for player,pitcher,items, and pitch models

    }
}
