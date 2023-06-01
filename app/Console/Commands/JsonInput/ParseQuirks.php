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
        $directory = 'public';
        $quirkSS = Storage::get($directory . '/quirks.json');
        $data = json_decode($quirkSS, true);
        foreach ($data['quirks'] as $quirk) {
            $name = $quirk['name'];

            $description = $quirk['description'];
            $newQuirk = new Quirk(['name' => $name, 'description' => $description]);
            $newQuirk->save();
            $this->info($newQuirk . ' inserted into table');
        }
        $this->info('Quirks saved successfully');
    }
}
