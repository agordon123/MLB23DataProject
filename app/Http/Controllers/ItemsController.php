<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
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
            'type' => 'required|string:mlb_card',
            'img'=>'sometimes|string',
            'baked_img'=>'sometimes|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), 400
            ]);
        };
        $item = Item::create([
            'uuid'=>$request->item['uuid']
        ]);
    }
    /**
     * Get Items from Web
     *
     * @param string $id
     * @return void
     */
    public function parseFromWeb(Request $request)
    {
        $request = Http::get('https://mlb23.theshow.com/apis/items.json?type=mlb_card');
        $dataJson = json_decode($request,true);
        
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
