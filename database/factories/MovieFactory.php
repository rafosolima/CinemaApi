<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Actor;
use App\Director;
use App\MaturityRating;
use App\Movie;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Movie::class, function (Faker $faker) {
    return [
        "maturity_rating_id" => function () {
            return factory(MaturityRating::class)->create()->id;
        },
        "name" => $faker->unique()->name,
        "sinopse" => Str::random(100),
        "duration" => rand(100, 200),
        "imdb" => rand(0, 10)
    ];
});
