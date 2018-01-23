<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index($slug){
        $user = User::where('slug', $slug)->first();
        return view('user.profile', compact('user'));
    }

    public function edit(){
        
        return view('user.profile.edit')->with('info', Auth::user()->profile);
    }


}
