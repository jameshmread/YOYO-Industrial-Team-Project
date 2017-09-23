<?php

namespace Tests\CSV;

use Tests\TestCase;
use Illuminate\Support\Facades\URL;

class UserTest extends TestCase
{
    public function testTrue()
    {
        $this->assertTrue(true);
    }
    // public function testRoute()
    // {
    //     $response = $this->get(URL::to('/api/unique-users-per-store'));
    //     $response->assertStatus(200);
    // }
}