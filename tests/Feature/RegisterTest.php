<?php

namespace Tests\Feature;

use App\Http\Controllers\JWTAuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsRequiresPasswordEmailAndName() : void
    {
        $response = $this->postJson('api/v1/auth/register');
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]
        ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'test',
            'email' => 'email@teste.com',
            'password' => '123456'
        ]);

        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'password' => ['The password confirmation does not match.']
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsRegistersSuccessfully() : void
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'test',
            'email' => 'email@teste.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }
}
