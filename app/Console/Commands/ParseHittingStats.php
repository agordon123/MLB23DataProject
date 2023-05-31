<?php

namespace App\Console\Commands;

use App\Models\HittingStats;
use App\Models\Item;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseHittingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-hitting-stats';

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
            $type =   $item['type'];
            $rarity =   $item['rarity'];

            $name = $item['name'];
            $img = $item['img'];
            $baked_img = $item['baked_img'];



           
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
            $baserunning_ability = $item['baserunning_ability'];
            $baserunning_aggression = $item['baserunning_aggression'];
            $hittingStats = [


                'contact_left' => $contact_left,
                'contact_right' => $contact_right,
                'power_left' => $power_left,
                'power_right' => $power_right,
                'plate_vision' => $plate_vision,
                'plate_discipline' => $plate_discipline,
                'batting_clutch' =>  $batting_clutch,
                'bunting_ability' => $bunting,
                'baserunning_ability' => $baserunning_ability,
                'baserunning_aggression' => $baserunning_aggression,


            ];

            $player = new HittingStats($hittingStats);
            $player->save();
            $this->info($item . ' Saved', $player . ' Saved');
        }
        $this->info('Successsfully Parsed Items');
    }
}
