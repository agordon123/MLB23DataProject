<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\FieldingStats;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseFieldingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:new-fielding';

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
        $directoryPath = '/public/json/newly_added/';


        $jsonFilePaths = Storage::allFiles($directoryPath);

        $uuids = array_map(function ($filePath) {
            return pathinfo($filePath, PATHINFO_FILENAME);
        }, $jsonFilePaths);
        foreach ($uuids as $uuid) {
            $newPlayer = Storage::get($directoryPath . "{$uuid}.json");
            $player = Player::where('uuid', $uuid)->first();
            $data = json_decode($newPlayer, true);

            //fielding stat fields

        }
    }
}
