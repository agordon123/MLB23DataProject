<?php

namespace App\Console\Commands;

use App\Models\Pitch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParsePitches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:pitches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Pitches.json';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = 'public';
        $pitches = Storage::get($directory . '/pitches.json');
        $data = json_decode($pitches, true);
        foreach ($data['pitches'] as $pitch) {
            $name = $pitch['name'];
            $abbreviation = $pitch['abbreviation'];
            $newPitch = new Pitch(['name' => $name, 'abbreviation' => $abbreviation]);
            $newPitch->save();
            $this->info($newPitch . ' saved');
        };
        // code a loop to connect pitchers pitches to the pivot table with player id and pitch id
        $this->info('pitches saved successfully');
    }
}
