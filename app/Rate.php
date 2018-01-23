<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'user_id', 'movie_id', 'rate'
    ];

    protected $table = 'rates';

}
