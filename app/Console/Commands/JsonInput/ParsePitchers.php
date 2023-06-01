<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Pitch;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParsePitchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:pitches';

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
        $directory = 'public/json/';
        $filename = 'items';
        for ($i = 1; $i <= 106; $i++) {

            $itemsJson = Storage::get($directory . $filename . $i . '.json');
            $data = json_decode($itemsJson, true);
            foreach ($data['items'] as $item) {
                if ($item['is_hitter'] == false) {
                    $uuid = $item['uuid'];
                    $dbPlayer = Player::where('uuid', $uuid)->first();


                    foreach ($item['pitches'] as $pitchData) {
                        $name = $pitchData['name'];
                        $speed = $pitchData['speed'];
                        $control = $pitchData['control'];
                        $break = $pitchData['movement'];

                        $pitch = Pitch::where('name', $name)->first();

                        if ($pitch) {
                            try {
                                DB::beginTransaction();
                                $dbPlayer->pitches()->attach($pitch->id, [
                                    'speed' => $speed,
                                    'control' => $control,
                                    'movement' => $break
                                ]);
                                DB::commit();
                                $this->info('Page ' . $i . ' Record saved, next');
                            } catch (Exception $e) {
                                DB::rollback();
                                $this->info($e);
                            }

                        }

                        $this->info($dbPlayer->uuid . ' player attached' . $pitch->id);
                    }
                }
            }
        }
    }
}
