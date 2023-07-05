<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Team;
use App\Models\Pitch;
use App\Models\Player;
use App\Models\Series;

use App\Models\HittingStats;
use App\Models\FieldingStats;
use App\Models\PitchingStats;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreatePlayerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $data = $this->data;


        $player = new Player();

        $player->uuid = $data['uuid'];
        $player->ovr =  $data['ovr'];
        $player->age = $data['age'];
        $player->img = $data['ovr'];
        $player->baked_img = $data['baked_img'];
        $player->rarity = $data['rarity'];
        $player->name = $data['name'];
        $player->height = $data['height'];
        $player->weight = $data['weight'];
        $player->bat_hand = $data['bat_hand'];
        $player->throw_hand = $data['throw_hand'];
        $player->position = $data['display_position'];
        $player->secondary_positions = $data['display_secondary_position'];
        $player->is_hitter = $data['is_hitter'];
        $player->save();
        

        //arrays of stats, quirks, pitches

        try{
         
            AddPlayerStatsJob::dispatch($player->uuid);
        }catch(Exception $e){
            echo($e);
        }





    }
}
