<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Support\Facades\Auth;
use App\User;


class FollowerController extends Controller
{

    public static function chat_res()
    {
        $all_fol_users = [];
        $fol_users = Follow::where('user_id', Auth::id())->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', Auth::id())->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }

        }

        return $all_fol_users;
    }

    public function showFollowers()
    {
        $followers_res = [];
        $following_res = [];

        $fwers_res = Follow::where('follower_id', Auth::id())->get();

        foreach ($fwers_res as $fwers_res_val){
            $followers_res[] = User::where('id', $fwers_res_val->user_id)->first();
        }


        $fwing_res = Follow::where('user_id', Auth::id())->get();
        foreach ($fwing_res as $fwing_res_val){
            $following_res[] = User::where('id', $fwing_res_val->follower_id)->first();
        }

        return view('user/followers', compact('followers_res', 'following_res'));
    }

}