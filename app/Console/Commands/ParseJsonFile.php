<?php

namespace App\Console\Commands;

use App\Models\Item;
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
       // $itemsJson = Storage::json('../../../storage/app/public/items.json');

        // Parse the JSON data
       // $items = json_decode($itemsJson, true);

        // Loop through each item and store in the database as an item first
     //ParseJsonFile.php   foreach ($items as $item) {
         //   $newItem = new Item(['uuid' => $item['uuid'], 'type' => $item['type'], 'rarity' => $item['rarity'], 'team' => $item['team']]);
         //   $newItem->save();
            // Create or find the Pitcher based on name
            //        if($newItem->type == 'mlb_card' ){
            //        $playerCollection.$newItem;
            //        if($newItem->is_hitter == true)

            //         $pitcher = Pitcher::firstOrCreate([
            //          'name' => $item['pitcher_name'],
            //             ]);
            //        }


            // Create the Pitch
            //          $pitch = $pitcher->pitches()->create([
            //           'name' => $item['pitch_name'],
            //               // Assign other pitch-specific attributes
            //       ]);
            //
            // Create the PitchAttributes for the Pitch
            //         $pitch->attributes()->create([
            //             'speed' => $item['speed'],
            //               'control' => $item['control'],
            //                'break' => $item['break'],
            //             // Assign other pitch attribute values
            //         ]);
     //   }

      //  $this->info('Items parsed and stored in the database.');
    }
}
