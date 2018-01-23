<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenreMovie extends Model
{
    protected $table = 'genre_movie';

    protected $guarded = ['id'];

    public function genres()
    {
        return $this->belongsTo('App\Genre');
    }

    public function movies()
    {
        return $this->hasOne('App\Movie','id','movie_id');
    }
}
