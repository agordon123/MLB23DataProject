<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'type' => 'required|string:mlb_card'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), 400
            ]);
        };
        if ($request->type == 'mlb_card') {
        }
    }
    /**
     * Undocumented function
     *
     * @param string $id
     * @return void
     */
    public function parseFromWeb(Request $request)
    {
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
