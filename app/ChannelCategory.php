<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelCategory extends Model
{
    protected $table = 'channel_categories';

    public function channels(){
        return $this->hasMany('App\Channel','category_id', 'id');
    }

    public function videos() {
        return $this->hasManyThrough('App\Videos', 'App\Channel', 'category_id' , 'channel_id', 'ch_id');
    }
}
