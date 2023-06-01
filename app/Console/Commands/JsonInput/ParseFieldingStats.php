<?php

namespace App\Console\Commands;

use App\Models\FieldingStats;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseFieldingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:fielding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Json for Fielding Stats';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = 'public/json/';
        $filename = 'items';




        for ($i = 1; $i <= 106; $i++) {
            $directory = 'public/json/';
            $filename = 'items';
            $itemsJson = Storage::get($directory . $filename . $i . '.json');
            $data = json_decode($itemsJson, true);
            foreach ($data['items'] as $item) {

                $uuid = $item['uuid'];
                $player = Player::byUUID($uuid)->first();
                $baserunning_ability = $item['baserunning_ability'];
                $baserunning_aggression = $item['baserunning_aggression'];
                $fielding_ability = $item['fielding_ability'];
                $durability = $item['fielding_durability'];
                $armAcc = $item['arm_accuracy'];
                $armStrength = $item['arm_strength'];
                $reaction = $item['reaction_time'];
                $blocking = $item['blocking'];
                $speed = $item['speed'];
                $hitting_durability = $item['hitting_durability'];
                if ($player) {
                    $stats = new FieldingStats(['player_id' => $player->id]);

                    $stats->baserunning_ability = $baserunning_ability;
                    $stats->baserunning_aggression = $baserunning_aggression;
                    $stats->fielding_ability = $fielding_ability;
                    $stats->fielding_durability = $durability;
                    $stats->arm_accuracy = $armAcc;
                    $stats->arm_strength = $armStrength;
                    $stats->reaction_time = $reaction;
                    $stats->blocking = $blocking;
                    $stats->speed = $speed;
                    $stats->hitting_durability = $hitting_durability;
                }


                $stats->save();





                $this->info(' Saved', $player->id . '  ' . $player->uuid);
            }
            $this->info('Successsfully Parsed Items');
        }
    }
}
