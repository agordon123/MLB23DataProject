<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Quirk;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttachQuirksToPlayers extends Command
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
        $directory = 'public/json/';
        $filename = 'items';

        for ($i = 1; $i <= 106; $i++) {
            $itemsJson = Storage::get($directory . $filename . $i . '.json');
            $data = json_decode($itemsJson, true);
            foreach ($data['items'] as $item) {
                $uuid = $item['uuid'];
                $quirks = $item['quirks'];
                $player = Player::byUUID($uuid)->first();
                foreach ($quirks as $quirkData) {
                    $quirkName = $quirkData['name'];
                    $dbQuirk = Quirk::byName($quirkName)->first();
                    if ($dbQuirk) {
                        $player->quirks()->attach($dbQuirk->id);
                    }
                }
            }
            try {
                DB::beginTransaction();
                DB::commit();
                $this->info('Page ' . $i . ' Record saved, next');
            } catch (Exception $e) {
                DB::rollback();
                $this->info($e);
            }
        }

        $this->info('File Finished');
    }
}
