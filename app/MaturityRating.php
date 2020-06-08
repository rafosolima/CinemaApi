<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaturityRating extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function movies() {
        return $this->hasMany(Movies::class);
    }
}
