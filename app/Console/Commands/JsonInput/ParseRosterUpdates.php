<?php

namespace App\Console\Commands;

use App\Models\RosterUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseRosterUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:updates';

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

        $directory ='public/json/roster_updates';
        $fileName = 'roster_updates-2023-06-03_21-38-51.json';
        $basicData = Storage::get($directory.$fileName);
        dd($basicData);
        $basicJsonData = json_decode($basicData,true);


        foreach($basicJsonData['roster_updates'] as $rosterData){
            $id = $rosterData['id'];
            $name = $rosterData['name'];
            $update = new RosterUpdate(['update_id'=>$id,'name'=>$name]);
            $update->save();
        }
    }
}
