<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\PitchingStats;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParsePitchingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-pitching-stats';

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
            $itemAttributes = [
                'uuid' =>   $uuid,
                'type' =>   $type,
                'rarity' => $rarity,
                'img' => $img,
                'baked_img' => $baked_img,
                'name' => $name,
                'type' => $type
            ];
           




            $pitcherAttributes = [
                'stamina' => $item['stamina'],
                'pitching_clutch' => $item['pitching_clutch'],
                'hits_per_bf' => $item['hits_per_bf'],
                'k_per_bf' => $item['k_per_bf'],
                'bb_per_bf' => $item['bb_per_bf'],
                'pitch_velocity' => $item['pitch_velocity'],
                'pitch_control' => $item['pitch_control'],
                'pitch_movement' => $item['pitch_movement']
            ];
            $player = new PitchingStats($pitcherAttributes);



            $player->save();
            $this->info($item . ' Saved', $player . ' Saved');
        }
        $this->info('Successfully Parsed Items');
    }
    }

