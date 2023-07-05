<?php

namespace App\Console\Commands;

use Exception;
use App\Listeners\JSONListener;
use Illuminate\Console\Command;


class ParseJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:items';

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
       
        $filePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . "data_items_page1.json");

        $stream = fopen($filePath, 'r');
        while(!feof($stream)){
            dd($stream);
        }
    
        try {
            $listener = new JSONListener([]);
            $parser = new \JsonStreamingParser\Parser($stream, $listener);
            $parser->parse();
        } catch (Exception $e) {
            fclose($stream);
            throw $e;
        }
    }


    /*  while (($line = fgets($stream)) !== false) {
            $data = json_decode($line, true);

            foreach ($data['attribute_changes'] as $changes) {
                $uuid = $changes['obfuscated_id'];
                $newRank = $changes['current_rank'];
                if ($changes['changes'] != null) {
                    foreach ($changes['changes'] as $attributeChange) {
                    }
                }
            }
            // Process this chunk of data...
            // If your JSON data is an array of objects, you may need to create jobs to process each object individually.
        }
    }*/
}
