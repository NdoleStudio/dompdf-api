<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_ping_returns_a_successful_response(): void
    {
        $response = $this->get('/ping');

        $response->assertStatus(200);
    }
}
