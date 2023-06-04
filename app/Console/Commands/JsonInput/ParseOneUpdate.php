<?php

namespace App\Console\Commands;

use App\Models\RosterUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParseOneUpdate extends Command
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
    protected $description = 'parses individual roster updates by id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $data = Http::get('https://mlb23.theshow.com/apis/roster_update?id={$id}');
        $jsonData = json_decode($data, true);
        $rosterUpdate = RosterUpdate::where('id',$id);

        foreach($jsonData as $key => $v){
            dd($key,$v);
            if($key == 'attribute_changes'){
                $rosterUpdate->attribute_changes = $v;
            }
            if($key== 'position_changes'){
                $rosterUpdate->position_changes = $v;
            }
        }
}
}
