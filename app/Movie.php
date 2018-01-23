<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;



class Movie extends Model
{

    protected $table = 'movies';



    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = array('id', 'movie_id', 'url', 'trailer', 'slug', 'title', 'type', 'genre_id', 'description', 'duration', 'poster', 'price', 'period', 'series_id', 'season_id');


    public function user()
    {
        return $this->belongsTo('App\User', 'user_movies')->withPivot('favorite', 'watchlist');
    }

//    public function genre() {
//        return $this->belongsTo('App\Genre', 'genre_id', 'id');
//    }

    public function director()
    {
        return $this->belongsToMany('App\Director');
    }

    public function studio()
    {
        return $this->hasOne('App\Studio');
    }

    public function actor()
    {
        return $this->belongsToMany('App\Actor');
    }

    public function getDuration()
    {
        return round($this->duration/60);
    }

    public function parental()
    {
        return $this->belongsTo('App\Parental');
    }


    public function isInWatchlist(\App\User $user){

        $favorited = UserList::where('user_id', $user->id)->where('movie_id', $this->id)->first();

        if(is_null($favorited)){
            return false;
        }
        return $favorited->watchlist;
    }
//
//    public function season()
//    {
//        return $this->hasMany('App\Season')->orderBy('number', 'asc');
//    }
//
//    public function episodes()
//    {
//        return $this->hasMany('App\Episode');
//    }
//
//    public function getSeasons() {
//
//        return $this->hasMany('App\Season')->where('movie_id', '=', '.$this->movie_id')->orderBy('season_number', 'asc');
//
//    }
//
//    public function getDefaultSeason($movie_id) {
//
//        return $this->hasMany('App\Season')->where('movie_id', '=', $movie_id)->orderBy('season_number', 'asc')->limit(1);
//
//    }




}
