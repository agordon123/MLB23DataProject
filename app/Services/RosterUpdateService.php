<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class RosterUpdateService
{
    protected $rosterUpdate;
    public function __construct($rosterUpdate)
    {
        $this->rosterUpdate = $rosterUpdate;
    }

    public function parseUpdate($rosterUpdate)
    {
        $this->rosterUpdate = Storage::get("public/json/roster_updates/roster_update12.json");
        $rosterUpdate = $this->rosterUpdate;
        $data = json_decode($rosterUpdate, true);
        foreach ($data['newly_added'] as $newPlayer) {
            dd($newPlayer);
        }
    }
}
