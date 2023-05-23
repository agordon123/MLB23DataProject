<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\Pitcher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseJsonFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:items-json';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse items.json file and store in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Read the contents of items.json
         $itemsJson = Storage::disk('public')->get('app/json/items.json');

         // Parse the JSON data
         $items = json_decode($itemsJson, true);
        $player = new Player();
         // Loop through each item and store in the database
         foreach ($items as $item) {
             // Create or find the Pitcher based on name
             if($item->type == '')
             $pitcher = Pitcher::firstOrCreate(['name' => $item['pitcher_name']]);

             // Create the Pitch
             $pitch = $pitcher->pitches()->create([
                 'name' => $item['pitch_name'],
                 // Assign other pitch-specific attributes
             ]);

             // Create the PitchAttributes for the Pitch
             $pitch->attributes()->create([
                 'speed' => $item['speed'],
                 'control' => $item['control'],
                 'break' => $item['break'],
                 // Assign other pitch attribute values
             ]);
         }

         $this->info('Items parsed and stored in the database.');
    }
}
