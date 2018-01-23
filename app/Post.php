<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    protected $table = 'posts';

    public function postCategory(){
        return $this->belongsTo('App\PostCategory', 'category_id');
    }
}
