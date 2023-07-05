<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class testPlayerSearchPerformance extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $start = microtime(true);

        // Perform the player search operation
        $response = $this->get('/players?name=Mike+Trout');
        $end = microtime(true);
        $executionTime = $end - $start;

        $this->assertTrue($executionTime < 0.1); // Assert that the execution time is within an acceptable range
    }
}
