<?php

namespace App\Console;

use App\Console\Commands\APICalls;
use App\Console\Commands\FillDatabaseWithPlayers;
use App\Console\Commands\GetItemsFromWeb;
use App\Console\Commands\LoadTableData;
use Illuminate\Console\Scheduling\Schedule;
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
        LoadTableData::class,
        FillDatabaseWithPlayers::class,
        APICalls::class,
        GetItemsFromWeb::class,
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
