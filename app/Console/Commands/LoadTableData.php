<?php

namespace App\Console\Commands;

use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LoadTableData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:data';

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
        
        $filePath = 'quirks.json';
        $directory = 'public/models/';
        $data = Storage::get($directory . $filePath);


       
        $json = json_decode($data,true);
        foreach($json['quirks'] as $quirks){
          
            $name = $quirks['name'];
            $description = $quirks['description'];
            $quirk = Quirk::create(['name'=>$name,'description'=>$description]);
            $quirk->save();
            $this->info($quirk. 'saved');
        }

        $directory = 'public/models/';
        $data = Storage::get($directory.'pitches.json');
        $json = json_decode($data,true);
        foreach($json['pitches'] as $pitch){
            $name = $pitch['name'];
            $abbreviation = $pitch['abbreviation'];
            $pitch = Pitch::create(['name'=>$name,'abbreviation'=>$abbreviation]);
            $pitch->save();
            $this->info($pitch . 'saved');
        }
        $data = Storage::get($directory . 'teams.json');
        $json = json_decode($data, true);
        foreach($json['teams']as $team){
            $new = Team::create(['name'=>$team['name'],'abbreviation'=>$team['abbreviation']]);
            $new->save();
            $this->info($new. 'saved');
            
        }
    }
}
