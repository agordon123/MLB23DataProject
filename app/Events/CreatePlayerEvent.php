<?php

namespace App\Events;

use App\Models\Item;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CreatePlayerEvent
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $id;
    public $data;
    /**
     * Create a new event instance.
     *
     * @param  Item  $item
     * @return void
     */
    public function __construct($id,$data)
    {
        $this->id = $id;
        $this->data = $data;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('listeners'),
        ];
    }
}

