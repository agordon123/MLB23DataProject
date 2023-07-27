<?php

namespace App\Console\Commands;

use App\Services\RosterUpdateService;
use Illuminate\Console\Command;

class ParseUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $rosterService;

    /**
     * Execute the console command.
     */
    public function handle()
    {
    }
}
