<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Team;
use App\Models\Pitch;
use App\Models\Player;
use App\Models\HittingStats;
use App\Models\FieldingStats;
use App\Models\PitchingStats;
use Illuminate\Console\Command;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AddStatsToPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:stats {page : The page number to start from}';

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
        $startPage = $this->argument('page');

        for ($page = $startPage; $page < 117; $page++) {
            //  $url = "https://mlb23.theshow.com/apis/items.json?type=mlb_card&page={$page}";
            //
            //
            //
            //  $itemsJson = Http::get($url);
            //  $data = $itemsJson->json();


            $filePath = storage_path("app/public/json/items{$page}.json");
            $data = file_get_contents($filePath);
            $dataJson = json_decode($data, true);

            $itemChunks = array_chunk($dataJson['items'], 100, true); // Adjust the chunk size as needed

            foreach ($itemChunks as $items) {
                $uuids = array_column($items, 'uuid');


                foreach ($items as $item) {
                    $uuid = $item['uuid'];

                    try {
                        $this->addTeam($uuid, $item);

                        $this->addHittingAndFieldingStats($uuid, $item);
                        if (!$item['is_hitter']) {
                            $this->addPitchingStats($uuid, $item);
                        }

                        echo ($uuid . ' saved');
                    } catch (\Throwable $th) {
                        echo ($th);
                    }
                }
            }
        }

        unset($data);

        $this->info('Page ' . $page . ' saved');
    }

    public function addHittingAndFieldingStats($uuid, array $item)
    {

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
        $contact_left = $item['contact_left'];
        $contact_right = $item['contact_right'];
        $power_left = $item['power_left'];
        $power_right = $item['power_right'];
        $batting_clutch = $item['batting_clutch'];
        $plate_vision = $item['plate_vision'];
        $plate_discipline = $item['plate_discipline'];
        $batting_clutch = $item['batting_clutch'];
        $bunting = $item['bunting_ability'];
        $drag = $item['drag_bunting_ability'];

        $fieldingStats = [
            'baserunning_ability' => $baserunning_ability, 'baserunning_aggression' => $baserunning_aggression,
            'fielding_ability' => $fielding_ability, 'durability' => $durability, 'arm_accuracy' => $armAcc, 'arm_strength' => $armStrength,
            'reaction_time' => $reaction, 'blocking' => $blocking, 'speed' => $speed, 'hitting_durability' => $hitting_durability, 'fielding_durability' => $durability
        ];
        $hittingStats = [
            'contact_left' => $contact_left,
            'contact_right' => $contact_right,
            'power_left' => $power_left,
            'power_right' => $power_right,
            'batting_clutch' => $batting_clutch,
            'plate_vision' => $plate_vision,
            'plate_discipline' => $plate_discipline,
            'bunting_ability' => $bunting,
            'drag_bunting_ability' => $drag
        ];
        $player = Player::where('uuid', $uuid)->first();
        $player->hittingStats()->create($hittingStats);
        $player->fieldingStats()->create($fieldingStats);
        $player->save();
    }
    public function addPitchingStats($uuid, array $item)
    {
        $pitchingStats = [
            "uuid" => $uuid,
            "stamina" => $item['stamina'],
            "pitching_clutch" => $item['pitching_clutch'],
            "hits_per_bf" => $item['hits_per_bf'],
            "k_per_bf" => $item['k_per_bf'],
            "bb_per_bf" => $item['bb_per_bf'],
            "hr_per_bf" => $item['hr_per_bf'],
            "pitch_velocity" => $item['pitch_velocity'],
            "pitch_control" => $item['pitch_control'],
            "pitch_movement" => $item['pitch_movement'],
        ];
        $pitches = $item['pitches'];
        $player = Player::where('uuid', $uuid)->first();
        foreach ($pitches as $pitchData) {
            $name = $pitchData['name'];
            $speed = $pitchData['speed'];
            $control = $pitchData['control'];
            $break = $pitchData['movement'];

            $pitch = Pitch::where('name', $name)->first();
            if ($pitch) {
                try {
                    DB::beginTransaction();
                    $player->pitches()->syncWithoutDetaching([$pitch->id => [
                        'speed' => $speed,
                        'control' => $control,
                        'movement' => $break
                    ]]);
                    $player->pitchingStats()->create($pitchingStats);
                    $player->save();
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $this->info($e);
                }
            }
        }
    }
    public function addTeam($uuid, array $item)
    {
        $team = $item['team'];
        $team = Team::where('abbreviation', $team)->first();
        $player = Player::where('uuid', $uuid)->first();
        $player->team = $team;
        $player->save();
        echo ($uuid . ' Team saved');
    }
}
