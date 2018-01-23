<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $tables = 'studios';

    protected $fillable = [
        'name', 'percent'
    ];

    //public function user()
    //{
    //    return $this->hasOne('User');
    //}

    public function movie()
    {
        return $this->hasMany('App\Movie');
    }
}
