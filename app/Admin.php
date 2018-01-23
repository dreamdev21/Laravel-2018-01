<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';


    protected $fillable = [
        'name', 'email', 'password', 'gender', 'username'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


}
