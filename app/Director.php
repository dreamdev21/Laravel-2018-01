<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{

    protected $table = 'directors';

    public function movie()
    {
        return $this->hasMany('App\Movie');
    }
}
