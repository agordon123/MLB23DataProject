<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Player;
use App\Models\HittingStats;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParseHittingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:hitting';

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
                $player = Player::byUUID($uuid)->first();
                $id = $player->id;
                $contact_left = $item['contact_left'];
                $contact_right = $item['contact_right'];
                $power_left = $item['power_left'];
                $power_right = $item['power_right'];
                $plate_vision = $item['plate_vision'];
                $plate_discipline = $item['plate_discipline'];
                $batting_clutch = $item['batting_clutch'];
                $bunting_ability = $item['bunting_ability'];
                $drag_bunting_ability = $item['drag_bunting_ability'];
                if ($player) {

                    $hittingStats = new HittingStats(['player_id' => $id,]);
                    $hittingStats->contact_left = $contact_left;
                    $hittingStats->contact_right = $contact_right;
                    $hittingStats->power_left = $power_left;
                    $hittingStats->power_right = $power_right;
                    $hittingStats->plate_vision = $plate_vision;
                    $hittingStats->plate_discipline = $plate_discipline;
                    $hittingStats->batting_clutch = $batting_clutch;
                    $hittingStats->bunting_ability = $bunting_ability;
                    $hittingStats->drag_bunting_ability = $drag_bunting_ability;

                    try {


                        $hittingStats->save();



                        $this->info($uuid . ' Saved, Player ID: ' . $player->id);
                    } catch (Exception $e) {
                        DB::rollback();
                        $this->info($e);
                    }
                } else {
                    $this->info('Player with UUID ' . $uuid . ' not found.');
                }
            }

            $this->info('Page ' . $i . ' Record saved, next');
        }
        $this->info('Hitting Stats Parsed');
    }
}
