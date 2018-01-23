<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [
        'id', 'user_id', 'movie_id'
    ];

    protected $table = 'watchlists';
    public $timestamps = false;
}
