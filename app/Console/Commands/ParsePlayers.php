<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use App\Models\Pitcher;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Http\Resources\QuirkResource;
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
        $players = Storage::get($directory . '/items.json');
        $json = json_decode($players, true);
        //get quirks to use to attach to players
        $quirks = Storage::get($directory . './quirks.json');




        //above code sets up items.json to parse for player,pitcher,items, and pitch models
        foreach ($json['items'] as $item) {

            $uuid = $item['uuid'];
            $type =   $item['type'];
            $rarity =   $item['rarity'];
            $team = $item['team'];
            $pitcherAttributes = [];
            $itemAttributes = [
                'uuid' =>   $uuid,
                'type' =>   $type,
                'rarity' => $rarity,
                'team ' =>  $team
            ];
            $ovr = $item['ovr'];
            $age = $item['age'];
            $height = $item['height'];
            $bh = $item['bat_hand'];
            $th = $item['throw_hand'];
            $weight = $item['weight'];
            $is_hitter = $item['is_hitter'];
            $contact_left = $item['contact_left'];
            $contact_right = $item['contact_right'];
            $position  = $item['display_position'];
            $secondary_position = $item['display_secondary_position'];
            $power_left = $item['power_left'];
            $power_right = $item['power_right'];
            $plate_vision = $item['plate_vision'];
            $plate_discipline = $item['plate_discipline'];
            $batting_clutch = $item['batting_clutch'];
            $bunting = $item['bunting_ability'];
            $baserunning_ability = $item['baserunning_ability'];
            $baserunning_aggression = $item['baserunning_aggression'];
            $playerAttributes = [

                'ovr' => $ovr,
                'age' => $age,
                'height' =>  $height,
                'weight' => $$weight,
                'bat_hand' => $bh,
                'throw_hand' => $th,
                'display_position' => $position,
                'secondary_position' => $secondary_position,
                'is_hitter' => $is_hitter,
                'contact_left' => $contact_left,
                'contact_right' => $contact_right,
                'power_left' => $power_left,
                'power_right' => $power_right,
                'plate_vision' => $plate_vision,
                'plate_discipline' => $plate_discipline,
                'batting_clutch' =>  $batting_clutch,
                'bunting_ability' => $bunting,
                'baserunning_ability' => $baserunning_ability,
                '$baserunning_aggression' => $baserunning_aggression
            ];

            $player = new Player($playerAttributes);

            $item = new Item($itemAttributes);
            $item->player()->associate($player);
            $item->save();
            $player->save();


            if ($item['is_hitter'] == true) {
            }




        }
    }
}
