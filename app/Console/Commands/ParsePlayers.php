<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Item;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParsePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Players out of items.json. Teams, pitches, and quirk tables must be seeded before running this command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //parse json file from public storage
        $directory = 'public';
        $page = $this->argument('page');
        $players = Storage::get($directory . '/items.json');



        $itemsJson = Http::get('https://mlb23.theshow.com/apis/items.json?type=mlb_card');

        $json = json_decode($itemsJson, true);

        //above code sets up items.json to parse for player,pitcher,items, and pitch models
        foreach ($json['items'] as $item) {

            $uuid = $item['uuid'];
            $type =   $item['type'];
            $rarity =   $item['rarity'];
            $name = $item['name'];
            $img = $item['img'];
            $baked_img = $item['baked_img'];
            $team = $item['team'];
            $teamId = Team::searchByName($team);
            dd($teamId);







            $ovr = $item['ovr'];
            $age = $item['age'];
            $height = $item['height'];
            $bh = $item['bat_hand'];
            $th = $item['throw_hand'];
            $weight = $item['weight'];
            $is_hitter = $item['is_hitter'];
            $position  = $item['display_position'];
            $secondary_position = $item['display_secondary_positions'];
            $itemAttributes = [
                'uuid' =>   $uuid,
                'type' =>   $type,
                'rarity' => $rarity,
                'img' => $img,
                'baked_img' => $baked_img,
                'name' => $name,
            ];


            try {
                DB::beginTransaction();
                $item = Item::create($itemAttributes);
                $itemId = $item->id;
                $playerData = [

                    'ovr' => $ovr,
                    'age' => $age,
                    'height' =>  $height,
                    'weight' => $weight,
                    'bat_hand' => $bh,
                    'throw_hand' => $th,
                    'position' => $position,
                    'secondary_positions' => $secondary_position,
                    'is_hitter' => $is_hitter,
                    'item_id'=>$itemId


                ];
                // Save the item


                // Save the player and associate it with the item
                $player = Player::create($playerData);
                $player->item()->associate($item);
                $player->save();

                DB::commit();

                // Other processing or response
            } catch (Exception $e) {
                DB::rollback();
                $this->info($e);

                // Handle the exception
            }
            $this->info($item . ' Saved', $player . ' Saved');
        }
        $this->info('Successfully Parsed Items');
    }
}
