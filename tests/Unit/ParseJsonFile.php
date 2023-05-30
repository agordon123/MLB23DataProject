<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParseJsonFile extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testParsingJSONFileFromStorage()
    {
        // Define the path to the JSON file in the storage directory
        $directory = 'storage/app/public';



        // Create a sample JSON file for testing
        $json = '{"key": "value"}';
        $filePath = File::put($directory, $json);

        // Run your command
        $parsedData =  $this->artisan('parse:items-json');

        // Perform assertions on the output or side effects of the command
        // For example, you can assert that the parsed JSON data is correct
        // Retrieve the parsed data from your command logic
        $this->assertEquals('value', $parsedData['key']);

        // Clean up by deleting the sample JSON file
        File::delete($filePath);
    }
}
