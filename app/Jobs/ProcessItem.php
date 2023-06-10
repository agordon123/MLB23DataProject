<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Player;
use App\Jobs\CreateItemJob;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;
    protected $uuid;
    /**
     * Create a new job instance.
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get('https://mlb23.theshow.com/apis/item.json?uuid=' . $this->uuid);
        $data = $response->json();
        $type =   $data['type'];
        $rarity =   $data['rarity'];
        $name = $data['name'];
        $img = $data['img'];
        $baked_img = $data['baked_img'];

        $ovr = $data['ovr'];
        $age = $data['age'];
        $height = $data['height'];
        $bh = $data['bat_hand'];
        $th = $data['throw_hand'];
        $weight = $data['weight'];
        $is_hitter = $data['is_hitter'];
        $position  = $data['display_position'];
        $secondary_position = $data['display_secondary_positions'];
        $playerAttributes = [
            'ovr' => $data['ovr'],
            'age' => $data['age'],
            'height' => $data['height'],
            'weight' => $data['weight'],
            'bat_hand' => $data['bat_hand'],
            'throw_hand' => $data['throw_hand'],
            'is_hitter' => $data['is_hitter'],
        ];
        $player = new Player();

        $player->uuid = $this->uuid;
        $player->ovr = $ovr;
        $player->age = $age;
        $player->height = $height;
        $player->weight = $weight;
        $player->bat_hand = $bh;
        $player->throw_hand = $th;
        $player->position = $position;
        $player->secondary_positions = $secondary_position;
        $player->is_hitter = $is_hitter;


        $player->save();
        AddPlayerStatsJob::dispatch($data);
    }
}
