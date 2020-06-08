<?php

namespace Tests\Feature;

use App\MaturityRating;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaturityRatingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredNameAndDescriptionMaturityRating()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/maturityRating', [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(422)
          ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'description' => ['The description field is required.']
                ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExistsNameMaturityRating()
    {
        $user = factory(User::class)->create();
        $maturityRating = factory(MaturityRating::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/maturityRating', [
            'name' => $maturityRating->name,
            'description' => $maturityRating->description,
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
    public function testCreatedMaturityRating()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/maturityRating', [
            'name' => 'test',
            'description' => 'test description',
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
    public function testUpdatedExistsNameMaturityRating()
    {
        $user = factory(User::class)->create();
        $maturityRating = factory(MaturityRating::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/maturityRating/$maturityRating->id", [
            'name' => $maturityRating->name,
            'description' => $maturityRating->description,
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
    public function testUpdatedNotFoundMaturityRating()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/maturityRating/999999", [
            'name' => 'not found',
            'description' => 'test description',
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
    public function testUpdatedMaturityRating()
    {
        $user = factory(User::class)->create();
        $maturityRating = factory(MaturityRating::class)->create();
        $token = auth()->tokenById($user->id);

        $this->putJson("api/v1/maturityRating/$maturityRating->id", [
            'name' => 'new name',
            'description' => 'new description',
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
    public function testDestroyNotFoundMaturityRating()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/maturityRating/999999", [], [
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
    public function testDestroyMaturityRating()
    {
        $user = factory(User::class)->create();
        $maturityRating = factory(MaturityRating::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/maturityRating/{$maturityRating->id}", [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200);
    }
}
