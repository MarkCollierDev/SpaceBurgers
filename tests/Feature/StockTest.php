<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTest extends TestCase
{
    public function test_buns_exits()
    {
        $response = $this->get('/api/buns');
        $response->assertStatus(200);
    }

    public function test_fillings_exists()
    {
        $response = $this->get('/api/fillings');
        $response->assertStatus(200);
    }
}
