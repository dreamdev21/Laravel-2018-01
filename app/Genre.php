<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Genre extends Model
{
    protected $table = 'genres';


    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
//
//    public function movies() {
//        return $this->hasMany('App\Movie', 'genre_id', 'id');
//    }
//
//    public function Series() {
//        return $this->hasMany('App\Serie', 'genre_id', 'id');
//    }
}
