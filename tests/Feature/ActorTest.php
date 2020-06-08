<?php

namespace Tests\Feature;

use App\Actor;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredNameActor()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/actor', [], [
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
    public function testExistsNameActor()
    {
        $user = factory(User::class)->create();
        $actor = factory(Actor::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/actor', [
            'name' => $actor->name
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
    public function testCreatedActor()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/actor', [
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
    public function testUpdatedExistsNameActor()
    {
        $user = factory(User::class)->create();
        $actor = factory(Actor::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/actor/$actor->id", [
            'name' => $actor->name
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
    public function testUpdatedNotFoundActor()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/actor/999999", [
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
    public function testUpdatedActor()
    {
        $user = factory(User::class)->create();
        $actor = factory(Actor::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/actor/$actor->id", [
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
    public function testDestroyNotFoundActor()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/actor/999999", [], [
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
    public function testDestroyActor()
    {
        $user = factory(User::class)->create();
        $actor = factory(Actor::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/actor/{$actor->id}", [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200);
    }
}
