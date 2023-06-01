<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteJsonFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes json files created from http request';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $directory = 'public/json/';
        $filename = 'items';

        for ($i = 1; $i <= 25; $i++) {
            $filePath = $directory . $filename . $i . '.json';
            Storage::delete($filePath);
            $this->info($filePath . ' Deleted');
        }
    }
}
