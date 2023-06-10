<?php

namespace App\Http\Controllers;

use App\Http\Resources\RosterUpdateResource;
use App\Models\RosterUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RosterUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $updates = RosterUpdate::all();
        return (new RosterUpdateResource($updates))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'update_id' => 'required|integer|unique',
            'type' => 'required|string',
            'img' => 'sometimes|string',
            'baked_img' => 'sometimes|string',
            'rarity' => 'required|string',
            'name' => 'required|string'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RosterUpdate $rosterUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RosterUpdate $rosterUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RosterUpdate $rosterUpdate)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RosterUpdate $rosterUpdate)
    {
        //
    }
    public function updatePlayers(Request $request, RosterUpdate $rosterUpdate)
    {
        $rosterUpdate = RosterUpdate::find($request->id)->first();
        $players = $rosterUpdate->players;
    }
    public function findPlayersByUpdate(Request $request, RosterUpdate $rosterUpdate)
    {
    }
}
