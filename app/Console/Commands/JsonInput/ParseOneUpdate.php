<?php

namespace App\Console\Commands;

use App\Events\CreatePlayerEvent;
use App\Jobs\ParseDataJob;
use Exception;
use App\Models\Item;

use App\Models\Player;
use App\Models\Series;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ParseOneUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'parses individual roster updates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directoryPath = '/public/json/newly_added/';


        $jsonFilePaths = Storage::allFiles($directoryPath);
    /*   foreach($jsonFilePaths as $file){
            $handle = fopen($file, 'r');
            while (!feof($handle)) {
                $chunk = fread($handle, 4096); // Read a chunk of data

                // Process the chunk of data (e.g., parse JSON, perform operations)
                // You can work with the data chunk without loading the entire file into memory

                // Example: Decode JSON chunk and access data
                $data = json_decode($chunk, true);
                // Process the JSON data
                $uuid = $data['uuid'];
                $player = Player::where('uuid', $uuid)->first();
                if ($player) {
                    continue;
                }
                // Example: Perform operations on the data
                // ...

                // Clear the memory of the processed chunk
                unset($chunk);
            }

            fclose($handle);
       }&*/

        $uuids = array_map(function ($filePath) {
            return pathinfo($filePath, PATHINFO_FILENAME);
        }, $jsonFilePaths);

        foreach ($uuids as $uuid) {
            ParseDataJob::dispatch($uuid);
                $this->info($uuid." dispatched to ParseDataJob");
                // Other processing or response

        }
    }
}
