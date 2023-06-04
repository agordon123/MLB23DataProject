<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Player;
use App\Models\HittingStats;
use Illuminate\Http\Request;
use App\Events\CreatePlayerEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string',
            'type' => 'required|string',
            'img'=>'sometimes|string',
            'baked_img'=>'sometimes|string',
            'rarity'=>'required|string',
            'name'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), 400
            ]);
        };
        $item = Item::create([
            'uuid'=>$request->uuid,
            'type'=>$request->type,
            'img'=>$request->img,
            'baked_img'=>$request->baked_img,
            'rarity'=>$request->rarity

        ]);
        if ($item->type === 'mlb_card') {
            event(new CreatePlayerEvent($item));
        }
        return (new ItemResource($item))->response()->json(['message' => 'Item stored successfully',], 201);
    }
    /**
     * Get Items from Web
     *
     * @param string $id
     * @return void
     */
    public function parseFromWeb(Request $request)
    {
        $items = Item::all()->only('uuid');
        $request = Http::get('https://mlb23.theshow.com/apis/items.json?type=mlb_card');
        $dataJson = json_decode($request,true);
        foreach($dataJson['items'] as $item){
            $uuid = $item['uuid'];
            foreach($items['uuid'] as $uuidCheck){
                if($uuid == $uuidCheck){
                    
                }
            }
        }
    }
    public function createPlayer(Request $request)
    {
        $request->validate([
            'item_type' => 'required|string',
            // other validation rules
        ]);

        // Check if item_type is 'mlb_card'
        if ($request->item_type === 'mlb_card') {
            $playerData = [
                'ovr' => $request->input('ovr'),
                'age' => $request->input('age'),
                // fill in other player attributes
            ];

            $hittingStatsData = [
                'hits' => $request->input('hits'),
                'home_runs' => $request->input('home_runs'),
                // fill in other hitting stats attributes
            ];

            // Create the player
            $player = Player::create($playerData);

            // Create the hitting stats and associate it with the player
            $hittingStats = new HittingStats($hittingStatsData);
            $player->hittingStats()->save($hittingStats);

            // Create the item and associate it with the player
            $item = new Item([
                'type' => $request->input('item_type'),
                // fill in other item attributes
            ]);
            $item->itemable()->associate($player);
            $item->save();

            return response()->json(['message' => 'Player created successfully'], 201);
        }

        return response()->json(['message' => 'Item type does not require player creation'], 400);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);
        return new ItemResource($item);
    }
    /**
     *  updateName - updates name of item on table
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function updateName(Request $request, $uuid)
    {
        $newName = $request->input('name');

        Item::where('uuid', $uuid)->update(['name' => $newName]);

        return response()->json(['message' => 'Name updated successfully']);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(['Deleted item' . $id],204);
    }
}
