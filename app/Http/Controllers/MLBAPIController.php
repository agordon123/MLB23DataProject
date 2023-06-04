<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MLBAPIController extends Controller
{
    public function storeData(Request $request)
    {
        // Access the parsed data from the request
        $parsedData = $request->input('parsedData');

        // Store the data in the database using appropriate models and logic
        // Example: Use the desired model and store the data
        // YourModel::create($parsedData);

        // Perform any additional processing or validation as needed

        // Return a response or perform any other actions
        return response()->json(['message' => 'Data stored successfully']);
    }
}
