<?php

namespace App\Jobs;

use Exception;

use App\Models\Item;

use App\Models\Team;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use App\Models\Series;
use App\Jobs\CreateItemJob;
use App\Models\HittingStats;
use App\Jobs\CreatePlayerJob;
use App\Models\PitchingStats;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseDataJob implements ShouldQueue
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
    public function handle()
    {
        // Load JSON data from file
        $response = Http::get('https://mlb23.theshow.com/apis/item.json?uuid=' . $this->uuid);
        $data = $response->json();
        dd($data);


        try {
            if ($data['type'] == 'mlb_card') {
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


                AddPlayerStatsJob::dispatch($data);

            }
        } catch (Exception $e) {
            Log::error('Job failed!', ['error' => $e->getMessage()]);
        }
    }
}
