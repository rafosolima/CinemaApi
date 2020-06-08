<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function movies() {
        return $this->belongsToMany(Movies::class, 'movies_directors', 'director_id', 'movie_id')
                    ->withTimestamps();
    }
}
