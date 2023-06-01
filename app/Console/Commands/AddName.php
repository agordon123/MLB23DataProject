<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-name';

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
        $directory = 'public/';
        $filename = 'items';


        $itemsJson = Storage::get($directory . $filename . '1' . '.json');
        $data = json_decode($itemsJson, true);


        // Loop through each item and store in the database as an item first
        //above code sets up items.json to parse for player,pitcher,items, and pitch models
        foreach ($data['items'] as $item){
            $name = $item['name'];
            $uuid = $item['uuid'];
            Item::where('uuid', $uuid)->update(['name' => $name]);
        }
    }
}
