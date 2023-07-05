<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\HittingStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class HittingStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // YourController.php

  

    public function processPipedData(Request $request)
    {
        $pipedData = $request->all();

        // Process the piped data as needed
        // ...
        $hittingStats = new HittingStats([
            'player_id' => Player::byUUID($pipedData['uuid'])->first()->only('id'),
            "contact_left" => $pipedData['contact_left'],  "contact_right" => $pipedData['contact_right'], "power_left" => $pipedData['power_left'],
            "power_right" => $pipedData['power_right'], "plate_vision" => $pipedData['plate_vision'], "plate_discipline" => $pipedData['plate_discipline'],
            "batting_clutch" => $pipedData['batting_clutch'], "bunting_ability" => $pipedData['bunting'], "drag_bunting_ability" => $pipedData['drag_bunting_ability']
        ]);
        $hittingStats->save();
        // Return a response if required
        return response()->json(['message' => 'Data processed successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $content = $request->getContent();
        $content = json_decode($content,true);
        $hittingStats = new HittingStats([
            'player_id' => Player::byUUID($content->uuid)->first()->only('id'),
            "contact_left" => $content->contact_left,  "contact_right" => $content->contact_right, "power_left" => $content->power_left, 
            "power_right" => $content->power_right,"plate_vision" => $content->plate_vision, "plate_discipline" => $content->plate_discipline, 
            "batting_clutch" => $content->batting_clutch, "bunting_ability" => $content->bunting, "drag_bunting_ability" => $content->drag_bunting_ability
        ]);
        $hittingStats->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
