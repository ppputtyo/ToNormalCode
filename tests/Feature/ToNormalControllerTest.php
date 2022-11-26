<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToNormalControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/to-normal-code');
        $response->assertOk();
        $response->assertViewHas([
            "text" => "",
            "result" => "",
            "prev_function" => [1, 1, 1, 0, 0, 1, 0],
            "url" => []
        ]);
    }
}
