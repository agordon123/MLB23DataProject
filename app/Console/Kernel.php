<?php

namespace App\Console;

use Tests\Feature\ParseJsonFile;
use App\Console\Commands\ParseTeams;
use App\Console\Commands\ParseQuirks;
use App\Console\Commands\ParsePitches;
use App\Console\Commands\ParsePlayers;
use App\Console\Commands\LoadDataCommand;
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
        Commands\ParseJsonFile::class,
        Commands\ParsePitches::class,
        Commands\ParseQuirks::class,
        \App\Console\Commands\LoadDataCommand::class,
        \App\Console\Commands\ParsePlayers::class,
        \App\Console\Commands\ParseTeams::class
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
