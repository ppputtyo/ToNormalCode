<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_redirect()
    {
        $response = $this->get('/');
        // リダイレクトされる
        $response->assertStatus(302);
    }
}
