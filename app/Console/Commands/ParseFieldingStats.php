<?php

namespace App\Console\Commands;

use App\Models\FieldingStats;
use App\Models\Item;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseFieldingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-fielding-stats';

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
        $directory = 'public';
        $players = Storage::get($directory . '/items.json');



        $itemsJson = Http::get('https://mlb23.theshow.com/apis/items.json?type=mlb_card');
        dd($itemsJson);
        $json = json_decode($itemsJson, true);
        foreach ($json['items'] as $item) {

            $uuid = $item['uuid'];
            $name = $item['name'];
            $baserunning_ability = $item['baserunning_ability'];
            $baserunning_aggression = $item['baserunning_aggression'];
            $fieldingStats = [
                'baserunning_ability' => $baserunning_ability,
                'baserunning_aggression' => $baserunning_aggression,
                'fielding_ability' => $item['fielding_ability'],
                'fielding_durability' => $item['fielding_durability'],
                'arm_accuracy' => $item['arm_accuracy'],
                'arm_strength'=>$item['arm_strength'],
                'reaction_time' => $item['reaction_time'],
                'blocking' => $item['blocking'],
                'speed' => $item['speed'],
                'drag_bunting_ability' => $item['drag_bunting_ability'],
                'hitting_durability' => $item['hitting_durability']
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
            $secondary_position = $item['display_secondary_positions'];
            $power_left = $item['power_left'];
            $power_right = $item['power_right'];
            $plate_vision = $item['plate_vision'];
            $plate_discipline = $item['plate_discipline'];
            $batting_clutch = $item['batting_clutch'];
            $bunting = $item['bunting_ability'];

            $playerAttributes = [

                'ovr' => $ovr,
                'age' => $age,
                'height' =>  $height,
                'weight' => $weight,
                'bat_hand' => $bh,
                'throw_hand' => $th,
                'position' => $position,
                'secondary_positions' => $secondary_position,
                'is_hitter' => $is_hitter,
                'contact_left' => $contact_left,
                'contact_right' => $contact_right,
                'power_left' => $power_left,
                'power_right' => $power_right,
                'plate_vision' => $plate_vision,
                'plate_discipline' => $plate_discipline,
                'batting_clutch' =>  $batting_clutch,
                'bunting_ability' => $bunting,

                'fielding_ability' => $item['fielding_ability'],
                'fielding_durability' => $item['fielding_durability'],
                'arm_accuracy' => $item['arm_accuracy'],
                'reaction_time' => $item['reaction_time'],
                'blocking' => $item['blocking'],
                'speed' => $item['speed'],
                'drag_bunting_ability' => $item['drag_bunting_ability'],
                'hitting_durability' => $item['hitting_durability']

            ];

            $player = new FieldingStats($fieldingStats);



            $item->player()->associate($player);

            $item->save();
            $player->save();
            $this->info($item . ' Saved', $player . ' Saved');
        }
        $this->info('Successsfully Parsed Items');
    }
}
