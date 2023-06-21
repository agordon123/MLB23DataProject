<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PullFromMLB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:update {--update=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $update = $this->option('update');
        $page = $this->option('page');
        $items = $this->option('items');
        $response = Http::get("https://mlb23.theshow.com/apis/roster_update.json?id={$update}");
        $data = $response->json();
        $file = json_encode($data, JSON_PRETTY_PRINT);
        Storage::put("public/json/roster_updates/roster_update{$update}", $file);
    }
}
