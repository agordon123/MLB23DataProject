<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerResource;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::all();
        return PlayerResource::collection($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }
    /**
     * Parse items.json and
     *
     * @return void
     */
    public function getPlayerFromJson()
    {
        $players = Storage::json('/storage/app/public/items.json');
        foreach($players as $player){
            $item = new Item();
            $newPlayer = new Player();
            $item->uuid = $player['uuid'];
            $item->name = $player['name'];
            $item->type = $player['type'];
            $item->rarity = $player['rarity'];
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player = Player::find($player->id);
    }
}
