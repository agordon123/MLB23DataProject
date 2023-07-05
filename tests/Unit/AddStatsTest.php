<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class AddStatsToPlayersTest extends TestCase
{
    use RefreshDatabase;

    public function testAddStatsCommand()
    {
        // Prepare the test data, such as a specific page number and team
        $pageNumber = 1;
        $team = 'example_team';

        // Run the command with the test data
        //  Artisan::call('add:stats', [
        //       'page' => $pageNumber,
        //       'team' => $team,
        //  ],)->assertExitCode(0);

        // Perform assertions to verify the expected behavior
        // For example, check if the player records have been updated correctly
        $this->assertDatabaseHas('players', [
            // Add specific conditions based on your expectations
        ]);

        // You can also assert that specific relationships have been updated correctly
        $this->assertDatabaseHas('hitting_stats', [
            // Add specific conditions based on your expectations
        ]);

        $this->assertDatabaseHas('fielding_stats', [
            // Add specific conditions based on your expectations
        ]);

        $this->assertDatabaseHas('pitching_stats', [
            // Add specific conditions based on your expectations
        ]);

        $this->assertDatabaseHas('player_has_pitches', [
            // Add specific conditions based on your expectations
        ]);
    }
}
