<?php

namespace App\Console\Commands;

use App\Http\Controllers\MLBAPIController;
use Illuminate\Console\Command;

class ProcessPlayersCommand extends Command
{
    protected $signature = 'players:process';

    protected $description = 'Process player data';

    public function handle()
    {
        $controller = new MLBAPIController();
        $controller->processPlayerData();
    }
}
