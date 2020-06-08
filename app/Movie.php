<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'maturity_rating_id',
        'name',
        'sinopse',
        'duration',
        'imdb'
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function directors() {
        return $this->belongsToMany(Director::class, 'movies_directors', 'movie_id', 'director_id')
                    ->withTimestamps();
    }

    public function actors() {
        return $this->belongsToMany(Actor::class, 'movies_actors', 'movie_id', 'actor_id')
                    ->withTimestamps();
    }

    public function maturityRating() {
        return $this->hasOne(MaturityRating::class);
    }
}
