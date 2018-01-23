<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coplay extends Model
{
    protected $fillable = [
        'inv_from', 'inv_to', 'inv_mov_id', 'payment_id', 'exp_date'
    ];

    protected $table = 'coplay';
}
