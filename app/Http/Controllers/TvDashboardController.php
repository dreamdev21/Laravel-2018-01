<?php

namespace App\Http\Controllers;

use App\Channel;
use App\User;
use App\WatchHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TvDashboardController extends Controller
{
    public function index(){
        $channel = Channel::find(Auth::user()->channel_id)->id;
        return view('tv.dashboard.index',compact('channel'));
    }

    public function updateWatchers(Request $request){
        $channel = intval($request->input('channel'));
        $user_id = Auth::user()->id;
        $watcher = WatchHistory::where([['user_id', $user_id],['channel_id',$channel]])->first();
        if(!$watcher){
            $watcher = new WatchHistory();
            $watcher->user_id = Auth::user()->id;
            $watcher->channel_id = $channel;
            $watcher->count = 1;
            $watcher->updated_at = Carbon::now();
            $watcher->save();
        }
        else{
            $updated_at = Carbon::parse($watcher->updated_at);
            $refresh = $updated_at->addDay();
            $now = Carbon::now();
            if($now->gt($refresh)){
                $watcher->count++;
                $watcher->updated_at = $now;
                $watcher->save();
            }
        }
        return 'success';
    }

    public function getStatistics(){
        $watchers = WatchHistory::where('channel_id', Auth::user()->channel_id)->get();
        $res = [];
        foreach ($watchers as $watcher){
            $user = User::find($watcher->user_id);
            if(!empty($user->country)){
                if(array_key_exists($user->country, $res)) $res[$user->country] += $watcher->count;
                else $res[$user->country] = $watcher->count;
            }
        }
        $response = [];
        foreach ($res as $key => $value){
            $response[] = [$key, $value];
        }
        return $response;
    }
}
