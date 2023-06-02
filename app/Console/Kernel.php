<?php

namespace App\Console;


use App\Console\Commands\ParseItems;
use App\Console\Commands\AddTeamToItem;
use App\Console\Commands\ParsePitchers;
use App\Console\Commands\DeleteJsonFiles;
use App\Console\Commands\ParseHittingStats;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ParseFieldingStats;
use App\Console\Commands\AttachQuirksToPlayers;
use App\Console\Commands\HTTPGet\GetDataFromMLB;
use App\Console\Commands\ParseMetaData;
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
        ParseItems::class,
        AddTeamToItem::class,
        AttachQuirksToPlayers::class,
        ParsePitchers::class,
        ParseFieldingStats::class,
        ParseHittingStats::class,
        DeleteJsonFiles::class,
        GetDataFromMLB::class,
        ParseMetaData::class

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
