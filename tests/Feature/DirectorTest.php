<?php

namespace Tests\Feature;

use App\Director;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DirectorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredNameDirector()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/director', [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(422)
          ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.']
                ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExistsNameDirector()
    {
        $user = factory(User::class)->create();
        $director = factory(Director::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/director', [
            'name' => $director->name
        ], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(422)
          ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name has already been taken.']
                ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatedDirector()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/director', [
            'name' => 'test'
        ], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200)
          ->assertJsonStructure([
                'data'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdatedExistsNameDirector()
    {
        $user = factory(User::class)->create();
        $director = factory(Director::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/director/$director->id", [
            'name' => $director->name
        ], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => ['The name has already been taken.']
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdatedNotFoundDirector()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/director/999999", [
            'name' => 'not found'
        ], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(404)->assertJson([
            'message' => 'Not found'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdatedDirector()
    {
        $user = factory(User::class)->create();
        $director = factory(Director::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/director/$director->id", [
            'name' => 'new name'
        ], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200)
          ->assertJsonStructure([
                'data'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDestroyNotFoundDirector()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/director/999999", [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(404)
          ->assertJson([
                'message' => 'Not found'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDestroyDirector()
    {
        $user = factory(User::class)->create();
        $director = factory(Director::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/director/{$director->id}", [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200);
    }
}
