<?php

namespace App\Console\Commands;

use App\Models\Quirk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseQuirks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:parse-quirks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses quirks.json';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //parse json file from public storage
        $directory = 'public';
        $players = Storage::get($directory . '/items.json');
        $json = json_decode($players, true);
        //get quirks to use to attach to players
        $quirks = Storage::get($directory . './quirks.json');
        $quirkJson = json_decode($quirks, true);
        foreach ($quirkJson['quirks'] as $quirk) {
            $name = $quirk['name'];

            $description = $quirk['description'];
            $newQuirk = new Quirk(['name' => $name, 'description' => $description]);
            $newQuirk->save();
            $this->info($newQuirk . ' inserted into table');
        }
        $this->info('Quirks saved successfully');
    }
}
