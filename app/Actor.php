<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actors';

    public function movie()
    {
        return $this->belongsToMany('App\Movie', 'actors_movies');
    }
}
