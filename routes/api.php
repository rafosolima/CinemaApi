<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    return response()->json([
        'api' => "Cinema api v1"
    ]);
});

Route::prefix('v1/auth')->group(function(){
    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');
});

Route::prefix('v1')->middleware('jwt.verify')->group(function () {
    Route::get('maturityRating', 'MaturityRatingController@index');
    Route::get('maturityRating/{maturityRating}', 'MaturityRatingController@show');
    Route::post('maturityRating', 'MaturityRatingController@store');
    Route::put('maturityRating/{maturityRating}', 'MaturityRatingController@update');
    Route::delete('maturityRating/{maturityRating}', 'MaturityRatingController@destroy');

    Route::get('movie', 'MovieController@index');
    Route::get('movie/{movie}', 'MovieController@show');
    Route::post('movie', 'MovieController@store');
    Route::put('movie/{movie}', 'MovieController@update');
    Route::delete('movie/{movie}', 'MovieController@destroy');

    Route::get('director', 'DirectorController@index');
    Route::get('director/{director}', 'DirectorController@show');
    Route::post('director', 'DirectorController@store');
    Route::put('director/{director}', 'DirectorController@update');
    Route::delete('director/{director}', 'DirectorController@destroy');

    Route::get('actor', 'ActorController@index');
    Route::get('actor/{actor}', 'ActorController@show');
    Route::post('actor', 'ActorController@store');
    Route::put('actor/{actor}', 'ActorController@update');
    Route::delete('actor/{actor}', 'ActorController@destroy');

    Route::get('user', 'UserController@index');
    Route::get('user/{user}', 'UserController@show');
    Route::put('user/{user}', 'UserController@update');
    Route::delete('user/{user}', 'UserController@destroy');
});