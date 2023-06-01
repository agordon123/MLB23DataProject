<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Item;
use App\Models\Player;
use App\Models\PitchingStats;
use App\Models\pitching_stats;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParsePitchingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:pitching';

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

        $directory = 'public/json/';
        $filename = 'items';



        for ($i = 1; $i <= 106; $i++) {
            $itemsJson = Storage::get($directory . $filename . $i . '.json');
            $json = json_decode($itemsJson, true);
            foreach ($json['items'] as $item) {

                $uuid = $item['uuid'];
                if (!$item['is_hitter']){
                $player = Player::byUUID($uuid)->first();

                if ($player) {
                    $pitchingStats = new PitchingStats();

                    $pitchingStats->player_id = $player->id;
                    $pitchingStats->stamina = $item['stamina'];
                    $pitchingStats->pitching_clutch = $item['pitching_clutch'];
                    $pitchingStats->hits_per_bf = $item['hits_per_bf'];
                    $pitchingStats->bb_per_bf = $item['bb_per_bf'];
                    $pitchingStats->pitch_velocity = $item['pitch_velocity'];
                    $pitchingStats->pitch_control = $item['pitch_control'];
                    $pitchingStats->pitch_movement = $item['pitch_movement'];
                    $pitchingStats->k_per_bf = $item['k_per_bf'];
                    try {
                        DB::beginTransaction();
                        DB::commit();
                        $this->info('Page ' . $i . ' Record saved, next');
                    } catch (Exception $e) {
                        DB::rollback();
                        $this->info($e);
                    }
                    $pitchingStats->save();
                    $this->info('Saved');
                }

            }
            $this->info('Successfully Parsed Pitchers');
        }
    }
    }
}
