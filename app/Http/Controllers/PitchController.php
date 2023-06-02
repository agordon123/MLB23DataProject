<?php

namespace App\Http\Controllers;

use App\Http\Resources\PitchResource;
use App\Models\Pitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PitchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pitches = Pitch::all();

        return PitchResource::collection($pitches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required', 'abbreviation' => 'required'
        ]);
        if ($validated) {
            $pitch = new Pitch(['name ' => $request->name, 'abbreviation' => $request->abbrevation]);
            $pitch->save();
        }
        return response()->json('Pitch ID # ' . $pitch->id . 'saved',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pitch = Pitch::find($id);
        return PitchResource::collection($pitch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = Validator::make($request->all(), [
            'pitch_id' => 'required',
            'name' => 'required',
            'abbreviation' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pitch = Pitch::findOrFail($id);
        $pitch->delete();

        return response()->json(['data' => 'Pitch with id ' . $id . ' deleted'], 204);
    }
}
