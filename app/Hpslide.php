<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hpslide extends Model
{
    protected $fillable = [
        'img'
    ];

    protected $table = 'hp_sliders';
}
