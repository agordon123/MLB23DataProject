<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Item;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class ParseItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:items';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse items.json file and store Items in the database';
    protected $item;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Read the contents of items.json





        for ($i = 108; $i <= 112; $i++) {
            $directory = 'public/json/';
            $filename = "data_items_page{$i}.json";

            $itemsJson = Storage::get($directory . $filename);
            $data = json_decode($itemsJson, true);
     
            $currentUUIDs = Item::all()->pluck('uuid')->toArray();
            // Loop through each item and store in the database as an item first
            //above code sets up items.json to parse for player,pitcher,items, and pitch models
            foreach ($data['items'] as $item) {


                $uuid = $item['uuid'];
                if (in_array($uuid, $currentUUIDs)) {
                    // The UUID already exists in the DB
                    Log::info('The UUID already exists in the DB: ' . $item['uuid']);
                    continue;
                }
                $type =   $item['type'];
                $rarity =   $item['rarity'];
                $name = $item['name'];
                $img = $item['img'];
                $baked_img = $item['baked_img'];
                $ovr = $item['ovr'];
                $age = $item['age'];
                $height = $item['height'];
                $bh = $item['bat_hand'];
                $th = $item['throw_hand'];
                $weight = $item['weight'];
                $is_hitter = $item['is_hitter'];
                $position  = $item['display_position'];
                $secondary_position = $item['display_secondary_positions'];


                try {
                    DB::beginTransaction();
                    $itemModel = new Item();
                    $itemModel->uuid = $uuid;
                    $itemModel->type = $type;
                    $itemModel->img = $img;
                    $itemModel->baked_img = $baked_img;
                    $itemModel->rarity = $rarity;
                    $itemModel->name = $name;
                    $itemModel->team();
                    $itemModel->save();

                    $itemId = $itemModel->id;

                    $player = new Player();
                    $player->item_id = $itemId;
                    $player->uuid = $uuid;
                    $player->ovr = $ovr;
                    $player->age = $age;
                    $player->height = $height;
                    $player->weight = $weight;
                    $player->bat_hand = $bh;
                    $player->throw_hand = $th;
                    $player->position = $position;
                    $player->secondary_positions = $secondary_position;
                    $player->is_hitter = $is_hitter;

                    $player->save();

                    DB::commit();

                    // Other processing or response
                } catch (Exception $e) {
                    DB::rollback();
                    $this->info($e);

                    // Handle the exception
                }
                $this->info('Page '.$i.' Record saved, next');
            }
            $this->info('File Finished');
        }


    }
}
