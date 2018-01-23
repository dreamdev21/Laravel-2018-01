<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $fillable = [
        'id','video_id', 'title', 'description', 'url', 'channel_id', 'type', 'ads_id', 'o_num'
    ];

    protected $table = 'videos';

    public function channel(){
        return $this->belongTo('App\Channel','channel_id', 'id');
    }
}
