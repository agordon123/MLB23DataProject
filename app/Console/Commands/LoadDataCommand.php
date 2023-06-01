<?php

namespace App\Console\Commands;

use App\Models\Quirk;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


class LoadDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads Json Data and Inserts Into Table - takes filename argument (no extension)';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Specify the filename of the JSON file
        $page = $this->argument('page');
        $directory = 'public';


    }
}
