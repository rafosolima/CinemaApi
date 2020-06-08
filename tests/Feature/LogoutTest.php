<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRefreshToken()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/auth/refresh', [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200)
          ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in"
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/auth/logout', [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200)
          ->assertJson([
            'message' => 'Successfully logged out'
        ]);
    }
}
