<?php

namespace App\Jobs;

use App\Models\Quirk;
use App\Models\Player;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AddQuirks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;
    protected $uuid;
    /**
     * Create a new job instance.
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get('https://mlb23.theshow.com/apis/item.json?uuid=' . $this->uuid);
        $data = $response->json();
        $quirks = $data['quirks'];
        $player = Player::byUUID($this->uuid)->only('id');
        foreach ($quirks as $quirkData) {
            $quirk = Quirk::byName($quirkData['name'])->first();

            if ($quirk) {
                $player->quirks()->syncWithoutDetaching($quirk->id);
            }
        }
    }
}
