<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToSpecialTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access()
    {
        $response = $this->get('/to-special-code');
        $response->assertStatus(200);
    }
}
