<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'failed',
        'transaction_id',
        'movie_id',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function rentals()
    {
        return $this->hasMany('App\Rental')->OrderBy('created_at', 'DESC');
    }
}
