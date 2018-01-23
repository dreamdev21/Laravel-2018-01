<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';


    protected $fillable = [ 'user_id', 'movie_id' ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function  payment()
    {
        return$this->belongsTo('App\payment');
    }
}

