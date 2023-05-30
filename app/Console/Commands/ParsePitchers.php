<?php

namespace App\Console\Commands;

use App\Models\Pitch;
use App\Models\Pitcher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParsePitchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:parse-pitchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Pitcher and Pitches out of items.json. Pitch Table must be seeded first';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = 'public';
        $itemsJson = Storage::get('public/' . 'items' . '.json');
        $data = json_decode($itemsJson, true);
        $newPitcher = new Pitcher();
        $this->argument('uuid');
        foreach($data as $player)
        if ($player['is_hitter'] == false) {
            $pitchersPitches = [];
            $pitcherAttributes = [
                'pitching_clutch' => $data['pitching_clutch'],
                'hits_per_bf' => $data['hits_per_bf'],
                'k_per_bf' => $data['k_per_bf'],
                'bb_per_bf' => $data['bb_per_bf'],
                'pitch_velocity' => $data['pitch_velocity'],
                'pitch_control' => $data['pitch_control'],
                'pitch_movement' => $data['pitch_movement']
            ];
            if($player['pitches'] != null){
                foreach($player['pitches']['pitch'] as $pitch){
                    $name =  $pitch['name'];

                }
            }
            $pitcher = new Pitcher();
            $pitcher = $pitcher->newFromBuilder($pitcherAttributes);
            $pitcher->player()->associate($player);
            $pitcher->save();
            foreach ($data['pitches'] as $pitch) {
                $name = $pitch['name'];
                $pitchId = Pitch::where('name' == $name)->only('id');
                // Associate pitches with the pitcher using pivot table
                $speed = $pitch['speed'];
                $velocity = $pitch['velocity'];
                $break = $pitch['break'];
                $pitch = ['pitch_id' => $pitchId, 'player_id' => $player->id, 'speed' => $speed, 'velocity' => $velocity, 'break' => $break];
                $pitcher->pitches()->attach([$pitchId], $pitchersPitches);
            }
            $this->info($pitcher);
        }
    }
}
