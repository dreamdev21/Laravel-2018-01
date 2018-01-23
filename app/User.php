<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'username', 'avatar', 'role', 'studio_id', 'ip', 'lat', 'lng', 'country', 'country_code', 'api_token', 'channel_id', 'phone'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'profileUrl'
    ];

    public function getProfileUrlAttribute()
    {
        return route('users.profile', $this);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function movies()
    {
        return $this->belongsToMany('App\Movie', 'user_movies')->withPivot('favorite', 'watchlist');
    }

    public function isNot(User $user)
    {
        return $this->id !== $user->id;
    }

    public function isFollowing(User $user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    public function canFollow(User $user)
    {
        if(!$this->isNot($user))
        {
            return false;
        }

        return !$this->isFollowing($user);
    }

    public function canUnfollow(User $user)
    {
        return $this->isFollowing($user);
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follower_id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'user_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public static function findByUsernameOrFail(
        $uuid,
        $columns = array('*')
    ) {
        if ( ! is_null($user = static::whereUsername($uuid)->first($columns))) {
            return $user;
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
    }


}
