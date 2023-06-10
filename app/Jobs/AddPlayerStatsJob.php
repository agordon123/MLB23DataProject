<?php

namespace App\Jobs;

use Throwable;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Player;
use Illuminate\Bus\Batch;
use App\Models\HittingStats;
use App\Models\PitchingStats;

use Illuminate\Bus\Batchable;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class AddPlayerStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;

    protected $uuid;
    /**
     * Create a new job instance.
     */
    public function __construct($uuid)
    {
        $this->uuid =$uuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get('https://mlb23.theshow.com/apis/item.json?uuid=' . $this->uuid);
        $data = $response->json();

        if($data['is_hitter']){
            $batch = Bus::batch([
                new AddHittingAndFieldingStats($this->uuid),

                new AddQuirks($this->uuid),


            ])->then(function (Batch $batch) {
                // All jobs completed successfully...
            })->catch(function (Batch $batch, Throwable $e) {
                // First batch job failure detected...
            })->finally(function (Batch $batch) {
                // The batch has finished executing...
            })->dispatch();
        }else{
            $batch = Bus::batch([
                new AddHittingAndFieldingStats($this->uuid),

                new AddQuirks($this->uuid),
                new AddPitchingStats($this->uuid),

            ])->then(function (Batch $batch) {
                // All jobs completed successfully...
            })->catch(function (Batch $batch, Throwable $e) {
                // First batch job failure detected...
            })->finally(function (Batch $batch) {
                // The batch has finished executing...
            })->dispatch();
        }



       





    }

    protected function getFieldingStatsData(array $data)
    {
        $baserunning_ability = $data['baserunning_ability'];
        $baserunning_aggression = $data['baserunning_aggression'];
        $fielding_ability = $data['fielding_ability'];
        $durability = $data['fielding_durability'];
        $armAcc = $data['arm_accuracy'];
        $armStrength = $data['arm_strength'];
        $reaction = $data['reaction_time'];
        $blocking = $data['blocking'];
        $speed = $data['speed'];
        $hitting_durability = $data['hitting_durability'];
        $fieldingStats = [
            'baserunning_ability' => $baserunning_ability, 'baserunning_aggression' => $baserunning_aggression, 'fielding_ability' => $fielding_ability,
            'durability' => $durability, 'arm_accuracy' => $armAcc, 'arm_strength' => $armStrength, 'reaction' => $reaction, 'blocking' => $blocking, 'speed' => $speed, 'hiting_durability' => $hitting_durability,
            'fielding_durability' => $durability
        ];
        return $fieldingStats;
    }

    protected function getHittingStatsData(array $data)
    {
        $contact_left = $data['contact_left'];
        $contact_right = $data['contact_right'];
        $power_left = $data['power_left'];
        $power_right = $data['power_right'];
        $plate_vision = $data['plate_vision'];
        $plate_discipline = $data['plate_discipline'];
        $batting_clutch = $data['batting_clutch'];
        $bunting_ability = $data['bunting_ability'];
        $drag_bunting_ability = $data['drag_bunting_ability'];
        $hittingStats = [
            'contact_left' => $contact_left, 'contact_right' => $contact_right, 'power_left' => $power_left, 'power_right' => $power_right,
            'plate_vision' => $plate_vision, 'plate_discipline' => $plate_discipline, 'batting_clutch' => $batting_clutch, 'bunting_ability' => $bunting_ability,
            'drag_bunting_ability' => $drag_bunting_ability
        ];
        return $hittingStats;
    }

    protected function createOrUpdatePitchingStats(Player $player, array $data): void
    {
        $pitchingStatsData = [
            'stamina' => $data['stamina'],
            // Other fields here...
        ];

        $player->pitchingStats()->updateOrCreate([], $pitchingStatsData);
    }

    protected function syncPitches(Player $player, array $pitches): void
    {
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

    protected function syncQuirks(Player $player, array $quirks): void
    {
        foreach ($quirks as $quirkData) {
            $quirk = Quirk::byName($quirkData['name'])->first();

            if ($quirk) {
                $player->quirks()->syncWithoutDetaching($quirk->id);
            }
        }
    }


}
