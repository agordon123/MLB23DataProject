<?php

namespace App\Listeners;

use App\Models\Player;
use App\Events\CreatePlayerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePlayerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreatePlayerEvent $event): void
    {
        $item = $event->item;

        // Create the new player based on item data
        $player = Player::create([
            'name' => $item->name,
            // other player attributes
        ]);
    }
}
