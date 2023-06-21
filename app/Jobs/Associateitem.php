<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Associateitem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $player;
    /**
     * Create a new job instance.
     */
    public function __construct($player)
    {
        $this->player = $player;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $item = Item::where('uuid', $this->player->uuid);
        $item->associate($this->player);
        $item->save();
    }
}
