<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parental extends Model
{
    protected $table = 'parentals';

    public function movie()
    {
        return $this->hasMany('App\Movie');
    }
}
