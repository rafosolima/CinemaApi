<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiresEmailAndLogin()
    {
        $response = $this->postJson('api/v1/auth/login');

        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]
        ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $this->postJson('api/v1/auth/login', [
            'email' => 'test@test.com',
            'password' => '123456'
        ])->assertStatus(200)
          ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }
}
