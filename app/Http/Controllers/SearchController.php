<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\Movie;
use App\User;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search_res = array();
        $search_words = $request->search_words;
        $search_res['titles'] = Movie::select('slug', 'title', 'poster', 'type')->where('title', 'LIKE', '%'.$search_words.'%')->take(5)->get();
        $search_res['users'] = User::select('username', 'avatar')->where('name', 'LIKE', '%'.$search_words.'%')->where('role', '!=', 2)->where('role', '!=', 4)->where('role', '!=', 1)->take(5)->get();
        return response()->json($search_res);
    }

    public function searchCoPlay(Request $request)
    {

        //dd($request->movie_id);
        $search_words = $request->search_words;
        $search_res = $this->chat_res($search_words);

        if(empty($search_res)){
            $search_res = '';
        }
        return response()->json($search_res);
    }

    public static function chat_res($search_words)
    {
        $all_fol_users = [];
        $fol_users = Follow::where('user_id', Auth::id())->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', Auth::id())->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::select('id', 'username', 'avatar')->where('id', $get_fr->user_id)->where('username', 'LIKE', '%'.$search_words.'%')->first();
            }

        }

        return $all_fol_users;
    }


}
