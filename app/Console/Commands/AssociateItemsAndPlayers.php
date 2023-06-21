<?php

namespace App\Console\Commands;

use App\Jobs\Associateitem;
use App\Models\Item;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class AssociateItemsAndPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'associate:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans DB for Players with a Null Association for items, and Attaches them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 2630; $i < 2650; $i++) {
            $player = Player::where('id', $i)->first();
            Cache::put('uuid', $player->uuid);
            // $item = Item::findOrFail($player->uuid)->first();
            // if ($item) {
            //     $item->associate($player);
            //     $item->save();
            //     $this->info($item->uuid . 'saved');
            // }
        }

        /*      Player::where('item_id', null)->chunk(25, function ($players) {
            $memoryUsage = memory_get_usage();
            echo "Memory Usage: " . $this->formatBytes($memoryUsage);
            foreach ($players as $player) {
                dd($player);
            }
            $this->info($player->uuid . 'dispatched to queue worker');
        });*/
    }
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
