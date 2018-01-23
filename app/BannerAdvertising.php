<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerAdvertising extends Model
{
    protected $table = 'banner_advertisings';

    protected $fillable = [
        'link','image', 'title', 'description', 'public'
    ];

}
