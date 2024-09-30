<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(){
        $this->seed();
        
        $response = $this->postJson('/api/user/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                    "success",
                    "data",
                    "message"
            ]);
        $response->assertOk();
    }
}
