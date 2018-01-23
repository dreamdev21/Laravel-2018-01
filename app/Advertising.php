<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    protected $fillable = [
        'preroll_name','preroll_type', 'preroll_goto_link', 'preroll_mp4', 'preroll_skip_timer', 'preroll_thumbimg'
    ];

    protected $table = 'advertisings';
    public $timestamps = false;
}
