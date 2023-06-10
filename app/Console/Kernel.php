<?php

namespace App\Console;

use App\Console\Commands\AddNewPlayers;
use App\Console\Commands\AddStats;
use App\Console\Commands\ParseItems;
use App\Console\Commands\AddTeamToItem;
use App\Console\Commands\ParsePitchers;
use App\Console\Commands\DeleteJsonFiles;
use App\Console\Commands\ParseHittingStats;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ParseFieldingStats;
use App\Console\Commands\AttachQuirksToPlayers;
use App\Console\Commands\FetchMLBDataCommand;
use App\Console\Commands\GetItemsFromWeb;
use App\Console\Commands\HTTPGet\GetDataFromMLB;
use App\Console\Commands\IntakeDataCommand;
use App\Console\Commands\ParseMetaData;
use App\Console\Commands\ParseOneUpdate;
use App\Console\Commands\ParseRosterUpdates;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }
    protected $commands = [



    ];
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
