<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateRequestedNameEmailUser()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $response = $this->putJson("api/v1/user/{$user->id}", [], [
            'Authorization' => "Bearer {$token}"
        ]);
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.']
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $response = $this->putJson("api/v1/user/{$user->id}", [
            'name' => 'new user',
            'email' => 'teste@teste.com.br',
            "password" => '123456'
        ], [
            'Authorization' => "Bearer {$token}"
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $response = $this->deleteJson("api/v1/user/{$user->id}", [], [
            'Authorization' => "Bearer {$token}"
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }
}
