<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToNormalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access()
    {
        $response = $this->get('/to-normal-code');
        $response->assertStatus(200);
    }
}
