<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Serie extends Model
{

    protected $table = 'series';

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name', 'studio_id', 'poster', 'slug'
    ];

    public function genre() {
        return $this->belongsTo('App\Genre', 'genre_id', 'id');
    }


}
