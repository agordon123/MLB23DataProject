<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Item;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParsePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses Players out of items.json. Teams, pitches, and quirk tables must be seeded before running this command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //parse json file from public storage
        $directory = 'public';
        $page = $this->argument('page');
        $players = Storage::get($directory . '/items.json');



        $itemsJson = Http::get('https://mlb23.theshow.com/apis/items.json?type=mlb_card');

        $json = json_decode($itemsJson, true);


    }
}
