<?php

namespace App\Http\Controllers;

use App\BannerAdvertising;
use Illuminate\Http\Request;
use App\Channel;
use App\Videos;
use App\Post;
use Illuminate\Support\Facades\Session;
use Image;
use Storage;
use App\Http\Requests;
use App\ChannelCategory;
use App\Advertising;
use Carbon\Carbon;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use App\User;

class LiveController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function test()
    {
        return view('includes.vid_test');
    }

    public function getStrVideo($id)
    {
        $video = Videos::where('id', $id)->first();
        $filename = 'temp.m3u8';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($video->url, $tempImage);

        return response()->download($tempImage, $filename);
    }

    public function index(Request $request)
    {

        $my_ip = file_get_contents('https://freegeoip.net/json/'/*.$_SERVER['REMOTE_ADDR']*/);
        $timezone_by_ip = json_decode($my_ip,true);
        $continent = explode("/",$timezone_by_ip['time_zone']);
        $continent = $continent[0];

        $dt = Carbon::now();
        $curr_time = $dt->toDateTimeString();
        $curr_time_decimal = $dt->toDateTimeString();
        $endTime = strtotime("+240 minutes", strtotime($curr_time));
        $endTime = date("Y-m-d H:i:s", $endTime);
        $categories = ChannelCategory::with(['channels'])->get()->toArray();
        $last_watched_chan_id = Auth::user()->last_watched_video;
        $gchan_res = Channel::where('id', $last_watched_chan_id)->first();
        $category_res = null;
        if($gchan_res != null){
            $category_res = ChannelCategory::where('id', $gchan_res->category_id)->first();
        }
        foreach ($categories as $category_key => &$category) {
            foreach ($category['channels'] as $key => &$channel) {
//                $a = $channel['blacklist'];
//                dd($continent);
//                dd($category['channels'][$key] );
//                if (strpos($a, $continent) !== false) {
//                    unset( $categories[$category_key]['channels'][$key] );
//                    unset( $category['channels'][$key] );
//                    continue;
//                }

                $channel_id = $channel['id'];
                $live_video = Videos::where(['type' => 'live', 'channel_id' => $channel_id])->get()->toArray();
                $start_video = Videos::where(['channel_id' => $channel_id])
                    ->where('end_time', '>=', $curr_time_decimal)
                    ->where('start_time', '<=', $endTime)
                    ->orderBy('start_time','ASC')
                    ->get()->toArray();
                for($i = 0; $i < count($start_video); $i++){
                    $start_video[$i]['ads_id'] = Advertising::find($start_video[$i]['ads_id']);
                }
                for($i = 0; $i < count($live_video); $i++){
                    $live_video[$i]['ads_id'] = Advertising::find($live_video[$i]['ads_id']);
                }

                if(!empty($start_video)){
                    $channel['videos'] = $start_video;
                }
                $channel['live_video'] = $live_video;
                if($channel['bg_ads_id']){
                    $channel['bg_ads'] = Advertising::where('id', $channel['bg_ads_id'] )->first();
                }
            }
        }

//        if($gchan_res != null){
//            if($category_res != null){
//                $cat_id = $category_res->id;
//                $chan_id = $gchan_res->id;
//                $cat_w = null;
//                $chan_w = null;
//                for($j = 0; $j<count($categories); $j++){
//                    if($categories[$j]['id'] == $cat_id){
//                        $cat_w = $j;
//                        if(isset($categories[$j]['channels'][0])){
//                            for($k = 0; $k < count($categories[$j]['channels']); $k++){
//                                if($categories[$j]['channels'][$k]['id'] == $last_watched_chan_id){
//                                    $chan_w = $k;
//                                    if($cat_w != 0){
//                                        $out = array_splice($categories, $cat_w, 1);
//                                        array_splice($categories, 0, 0, $out);
//                                    }
//                                    if($chan_w != 0){
//                                        $out = array_splice($categories[0]['channels'], $chan_w, 1);
//                                        array_splice($categories[0]['channels'], 0, 0, $out);
//                                    }
//
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
        $data = array(
            'categories' => $categories,
            'curr_time' => $curr_time
        );

        $banner_ads = BannerAdvertising::where('id', 1)->first();
//        dd($news_livetv);
//        dd($banner_ads);
        return view('includes/live', compact('data', 'banner_ads'));
    }

    public static function newsFeed(){
        return Post::orderBy('id', 'DESK')->take(15)->get()->random(4);
    }

    public function getLiveTv(Request $request)
    {
        $my_ip = file_get_contents('https://freegeoip.net/json/'/*.$_SERVER['REMOTE_ADDR']*/);

        $timezone_by_ip = json_decode($my_ip,true);
        $continent = explode("/",$timezone_by_ip['time_zone']);
        $continent = $continent[0];

        $dt = Carbon::now();
        $curr_time = $dt->toDateTimeString();
        $curr_time_decimal = $dt->toDateTimeString();
        $endTime = strtotime("+240 minutes", strtotime($curr_time));
        $endTime = date("Y-m-d H:i:s", $endTime);

        //$categories = ChannelCategory::with(['channels' => function ($query){
            //$query->where('published', true);}])->get()->toArray();
        $categories = ChannelCategory::with(['channels'])->get()->toArray();
        $last_watched_chan_id = Auth::user()->last_watched_video;
        $gchan_res = Channel::where('id', $last_watched_chan_id)->first();
        $category_res = null;
        if($gchan_res != null){
            $category_res = ChannelCategory::where('id', $gchan_res->category_id)->first();
        }
        foreach ($categories as $category_key => &$category) {
            foreach ($category['channels'] as $key => &$channel) {
                $a = $channel['blacklist'];
//                dd(strpos($a, $continent),$continent,$a);
//                dd($continent);
//                if (strpos($a, $continent) !== false) {
////                    unset( $categories[$category_key]['channels'][$key] );
//                    unset( $channels );
//                    continue;
//                }

                $channel_id = $channel['id'];
                $live_video = Videos::where(['type' => 'live', 'channel_id' => $channel_id])->get()->toArray();
                $start_video = Videos::where(['channel_id' => $channel_id])
                    ->where('end_time', '>=', $curr_time_decimal)
                    ->where('start_time', '<=', $endTime)
                    ->orderBy('start_time','ASC')
                    ->get()->toArray();
                for($i = 0; $i < count($start_video); $i++){
                    $start_video[$i]['ads_id'] = Advertising::find($start_video[$i]['ads_id']);
                }
                for($i = 0; $i < count($live_video); $i++){
                    $live_video[$i]['ads_id'] = Advertising::find($live_video[$i]['ads_id']);
                }

                if(!empty($start_video)){
                    $channel['videos'] = $start_video;
                }
                $channel['live_video'] = $live_video;
                if($channel['bg_ads_id']){
                    $channel['bg_ads'] = Advertising::where('id', $channel['bg_ads_id'] )->first();
                }
            }
        }

        $data = array(
            'categories' => $categories,
            'curr_time' => $curr_time
        );

        echo json_encode($data);

    }

    public static function getLiveTvURL()
    {
        $my_ip = file_get_contents('https://freegeoip.net/json/'/*.$_SERVER['REMOTE_ADDR']*/);

        $timezone_by_ip = json_decode($my_ip,true);
        $continent = explode("/",$timezone_by_ip['time_zone']);
        $continent = $continent[0];

        $dt = Carbon::now();
        $curr_time = $dt->toDateTimeString();
        $curr_time_decimal = $dt->toDateTimeString();
        $endTime = strtotime("+240 minutes", strtotime($curr_time));
        $endTime = date("Y-m-d H:i:s", $endTime);
        $categories = ChannelCategory::with(['channels'])->get()->toArray();

        $category_res = null;

        foreach ($categories as $category_key => &$category) {
            foreach ($category['channels'] as $key => &$channel) {
//                $a = $channel['blacklist'];
//                dd(strpos($a, $continent),$continent,$a);
//                dd($continent);
//                if (strpos($a, $continent) !== false) {
//                    unset( $categories[$category_key]['channels'][$key] );
//                    unset( $channels );
//                    continue;
//                }

                $channel_id = $channel['id'];
                $live_video = Videos::where(['type' => 'live', 'channel_id' => $channel_id])->get()->toArray();
                $start_video = Videos::where(['channel_id' => $channel_id])
                    ->where('end_time', '>=', $curr_time_decimal)
                    ->where('start_time', '<=', $endTime)
                    ->orderBy('start_time','ASC')
                    ->get()->toArray();

                if(!empty($start_video)){
                    $channel['videos'] = $start_video;
                }
                $channel['live_video'] = $live_video;
            }
        }

        $data = array(
            'categories' => $categories,
            'curr_time' => $curr_time
        );

        $channel = Channel::where('ch_to_front',1)->first();

        if(!$channel) return false;

              for($t=0; $t < count($data['categories']); $t++){
                for($k=0; $k<count($data['categories'][$t]['channels']); $k++){
                  if($data['categories'][$t]['channels'][$k]['id'] == $channel->id) {
                      $sel_channel = $data['categories'][$t]['channels'][$k];
//                      $channel_poster = sel_channel.logo;

                      if(isset($sel_channel['videos']) ==false ){
                        return false;
                      }
                      else{
                          for($b=0; $b<count($sel_channel['videos']);$b++){
                              $vid_start_time = $sel_channel['videos'][$b]['start_time'];

                              $vid_end_time   = $sel_channel['videos'][$b]['end_time'];
                              $time_now =$data['curr_time'];

                              if($time_now > $vid_start_time && $time_now < $vid_end_time){

                                  return $sel_channel['videos'][$b]['url'];

                              }
                          }
                      }
                  }
                }
              }

    }

}
