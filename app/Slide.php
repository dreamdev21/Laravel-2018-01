<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';

    public $timestamps = 'true';

    public function movie(){

        return $this->belongsTo('App\Slide');
    }


}
