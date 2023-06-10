<?php

namespace App\Jobs;

use App\Models\Pitch;
use App\Models\Player;
use App\Models\PitchingStats;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AddPitchingStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;
    protected $uuid;
    /**
     * Create a new job instance.
     */
    public function __construct($uuid)
    {
        $this->uuid  = $uuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get('https://mlb23.theshow.com/apis/item.json?uuid=' . $this->uuid);
        $data = $response->json();
        if(!$data['is_hitter']){
            $pitches = $data['pitches'];
            $pitchingStats = new PitchingStats();
            $player = Player::byUUID($this->uuid);
            $pitchingStats->player_id = $player->id;
            $pitchingStats->stamina = $data['stamina'];
            $pitchingStats->pitching_clutch = $data['pitching_clutch'];
            $pitchingStats->hits_per_bf = $data['hits_per_bf'];
            $pitchingStats->bb_per_bf = $data['bb_per_bf'];
            $pitchingStats->pitch_velocity = $data['pitch_velocity'];
            $pitchingStats->pitch_control = $data['pitch_control'];
            $pitchingStats->pitch_movement = $data['pitch_movement'];
            $pitchingStats->k_per_bf = $data['k_per_bf'];
            $player->pitchingStats()->updateOrCreate([],$pitchingStats);
            foreach ($pitches as $pitchData) {
                $pitch = Pitch::where('name', $pitchData['name'])->first();

                if ($pitch) {
                    $player->pitches()->syncWithoutDetaching([
                        $pitch->id => [
                            'speed' => $pitchData['speed'],
                            'control' => $pitchData['control'],
                            'movement' => $pitchData['movement'],
                        ]
                    ]);
                }
            }
        }

    }
}
