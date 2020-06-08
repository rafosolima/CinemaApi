<?php

namespace Tests\Feature;

use App\Actor;
use App\Director;
use App\MaturityRating;
use App\Movie;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredMaturityRatingDirectorsActorsNameSinopseDurationAndImdbMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->postJson('api/v1/movie', [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(422)
          ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'maturity_rating_id' => ['The maturity rating id field is required.'],
                    'directors' => ['The directors field is required.'],
                    'actors' => ['The actors field is required.'],
                    'name' => ['The name field is required.'],
                    'sinopse' => ['The sinopse field is required.'],
                    'duration' => ['The duration field is required.'],
                    'imdb' => ['The imdb field is required.']
                ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExistsNameMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $maturityRating = factory(MaturityRating::class)->create();

        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;

        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;

        $movie = factory(Movie::class)->create();

        $this->postJson('api/v1/movie', [
            'maturity_rating_id' => $movie->maturity_rating_id,
            'name' => $movie->name,
            'sinopse' => $movie->sinopse,
            'duration' => $movie->duration, 
            'imdb' => $movie->imdb,
            'actors' => $actors,
            'directors' => $directors
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
    public function testCreatedMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $maturityRating = factory(MaturityRating::class)->create();

        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;

        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;

        $this->postJson('api/v1/movie', [
            'maturity_rating_id' => $maturityRating->id,
            'name' => 'movie test',
            'sinopse' => 'Sinopse test',
            'duration' => 120, 
            'imdb' => 10,
            'actors' => $actors,
            'directors' => $directors
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
    public function testUpdatedExistsNameMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;

        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;

        $movie = factory(Movie::class)->create();

        $this->putJson("api/v1/movie/$movie->id", [
            'maturity_rating_id' => $movie->maturity_rating_id,
            'name' => $movie->name,
            'sinopse' => $movie->sinopse,
            'duration' => $movie->duration, 
            'imdb' => $movie->imdb,
            'actors' => $actors,
            'directors' => $directors
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
    public function testUpdatedNotFoundMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $maturityRating = factory(MaturityRating::class)->create();

        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;

        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;

        $this->putJson("api/v1/movie/999999", [
            'maturity_rating_id' => $maturityRating->id,
            'name' => 'movie test',
            'sinopse' => 'Sinopse test',
            'duration' => 120, 
            'imdb' => 10,
            'actors' => $actors,
            'directors' => $directors
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
    public function testUpdatedMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;
        $actors[] = factory(Actor::class)->create()->id;

        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;
        $directors[] = factory(Director::class)->create()->id;

        $movie = factory(Movie::class)->create();

        $this->putJson("api/v1/movie/$movie->id", [
            'maturity_rating_id' => $movie->maturity_rating_id,
            'name' => 'movie test',
            'sinopse' => 'Sinopse test',
            'duration' => 120, 
            'imdb' => 10,
            'actors' => $actors,
            'directors' => $directors
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
    public function testDestroyNotFoundMovie()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/movie/999999", [], [
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
    public function testDestroyMovie()
    {
        $user = factory(User::class)->create();
        $movie = factory(Movie::class)->create();
        $token = auth()->tokenById($user->id);

        $this->deleteJson("api/v1/movie/{$movie->id}", [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(200);
    }
}