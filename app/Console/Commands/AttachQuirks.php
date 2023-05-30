<?php

namespace App\Console\Commands;

use App\Models\Quirk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AttachQWirks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:quirks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attaches quirks and players with pivot table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = 'public/';
        $filename = 'items';


        $itemsJson = Storage::get($directory . $filename . '.json');
        $data = json_decode($itemsJson, true);

        if (isset($data['items']['quirks'])) {
            dd($data['items']['quirks']);
           // $player->save();
          //  foreach ($item['quirks'] as $name) {
           //     if ($quirkJson['name'] == $name) {
                //   dd($item['quirks']);
                //   $qID = $quirkJson['id'];
                //    Quirk::find($qID);
                 //   $player->quirks()->attach($qID);
               // }
           // }
        }
    }
}
