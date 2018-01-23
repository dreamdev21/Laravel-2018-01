<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'seasons';

    protected $fillable = [
        'number', 'series_id'
    ];
}
