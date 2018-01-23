<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use URL;
use File;
use App\Videos;
use App\Advertising;
use App\Channel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Vinelab\Youtube\Video;
use Mews\Purifier\Facades\Purifier;
use Carbon\Carbon;

class TvVideosController extends Controller
{
    public static function check_time_status($startTime, $endTime){

        $val = Carbon::now()->toDateTimeString();

        $ipaddress = $_SERVER['REMOTE_ADDR'];
        if($ipaddress == '127.0.0.1'){
            $ipaddress = '95.140.192.60';
        }
        $my_ip = file_get_contents('http://freegeoip.net/json/' . $ipaddress);
        $timezone_by_ip = json_decode($my_ip,true)['time_zone'];
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $val, 'UTC');

        $date->setTimezone($timezone_by_ip);

        $now = $date->toDateTimeString();

        if ($startTime < $now && $endTime > $now ){
            return "<span class='label label-success'> Now </span>";
        }elseif ($endTime<$now ){
            return "<span class='label label-danger'> Ended </span>";
        }
        elseif($startTime>$now){
            return "<span class='label label-hold'> Still Waiting </span>";
        }

    }

    function time_Diff_Minutes($startTime, $endTime) {
        $to_time = strtotime($endTime);
        $from_time = strtotime($startTime);
//            $minutes = ($to_time - $from_time) / 60;
        $minutes = ($to_time - $from_time) ;
        return ($minutes < 0 ? 0 : abs($minutes));

    }

    public function create(Request $request)
    {
        $prev_url = URL::previous();
        $channels = Channel::all();

//        $data['channels'] = $channels;
        $data['prev_url'] = $prev_url;
        $expl = explode('/', $data['prev_url']);
        $data['segment'] = end($expl);
        return view('tv.create', compact('data'));
    }


    public function add_video(Request $request)
    {
//        dd($request->all());
        $this->validate($request, array(
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
            'type' => 'required'
        ));

        $addedTime_h = $request->video_length_h;
        $addedTime_m = $request->video_length_m;
        $addedTime_s = $request->video_length_s;

        if(empty($addedTime_h) && empty($addedTime_m) && empty($addedTime_s)) return redirect()->back();

        if($addedTime_h == "")$addedTime_h= 0;
        if($addedTime_m == "")$addedTime_m= 0;
        if($addedTime_s == "")$addedTime_s= 0;

        $video = new Videos;

        /* Getting Start and end times */
        $max_end_time = Videos::where(['channel_id' => Auth::user()->channel_id])->max('end_time');
        $ch = Channel::where('id', Auth::user()->channel_id)->first();

        if($max_end_time == null) $max_end_time = $ch->start_time;

        $endTime = strtotime("+$addedTime_h hours $addedTime_m minutes $addedTime_s seconds", strtotime($max_end_time));
        $endTime = date("Y-m-d H:i:s", $endTime);
        $video->title  = $request->title;
        $video->description = Purifier::clean($request->description);
        $video->url = $request->url;
        $video->type = $request->type;
        $video->start_time = $max_end_time;
        $video->end_time = $endTime;
        if($request->has('ads')){
            if($request->input('ads') !== "null") $video->ads_id = $request->input('ads');
            else $video->ads_id = 0;
        }
        $video->channel_id = Auth::user()->channel_id;
        if(strpos($request->url, 'watch?v=')){
            $expl = explode('watch?v=', $request->url);
        }else{
            $expl = explode('/', $request->url);
        }
        $video->video_id = end($expl);
        $last_num = Videos::where([['channel_id', Auth::user()->channel_id],['o_num','<>',0]])->orderBy('o_num','desc')->first();
        if(!$last_num) $num = 1;
        else $num = $last_num->o_num + 1;
        $video->o_num = $num;
        $video->save();

        Session::flash('success', 'The new video was successfully added!');

        //redirect
        return redirect()->route('tvVideos');
    }



    public function del_video($id)
    {
        $video = Videos::find($id);

        if(Auth::user()->category_id == $video->category_id){
            $video->delete();
            Session::flash('message', 'video Successfully deleted!');
        }
        else{
            Session::flash('message', 'DELETING ERROR');
        }
        Session::flash('message', 'video Successfully deleted!');
        return redirect()->back();
    }





//    public function show($id)
//    {
//        //
//    }


    public function edit_video($id)
    {
        $video = Videos::find($id);
        $video['start_time'] = $this->edit_timezone($video['start_time'], true);
        $video['end_time'] = $this->edit_timezone($video['end_time'], true);
        return view('tv.edit', compact('video'));
    }
/*----------------*/
    public function index()
    {
        $ads = Advertising::where('user_id', Auth::id())->get();
        $videos = Videos::where('channel_id',Auth::user()->channel_id)->orderBy('o_num', 'asc')->get();
        $subscription = Subscription::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->subscription_type;
        $vide = [];
        $stream = [];
        foreach($videos as $vd){
            $currentDureation = $this -> time_Diff_Minutes($vd['start_time'],$vd['end_time']);
            $vd['start_time'] = $this->edit_timezone($vd['start_time'], true);
            $vd['end_time'] = $this->edit_timezone($vd['end_time'], true);
            $vd['dureation'] = gmdate('H:i:s',$currentDureation );
            $vd['img'] = null;
            if(strpos($vd['url'],'youtube') !== false){
                $img = explode('=',$vd['url'])[1];
                $vd['img'] = "https://img.youtube.com/vi/".$img."/0.jpg";
            }
            if(strpos($vd['url'],'.m3u8') !== false) $stream[] = $vd;
            else $vide[] = $vd;
        }
        foreach ($ads as $ad){
            if(!empty($ad['preroll_mp4'])) $ad['preroll_mp4'] = Storage::disk('s3frenvid')->url('ads/videos/'.$ad['preroll_mp4']);
        }
        $channel = Channel::find(Auth::user()->channel_id);
        return view('tv.index', compact('vide', 'ads', 'stream', 'channel', 'subscription'));
    }

    public function get_edit_body($id){
        $video = Videos::find($id);
        $video['start_time'] = $this->edit_timezone($video['start_time'], true);
        $video['end_time'] = $this->edit_timezone($video['end_time'], true);
        $ads = Advertising::where('user_id',Auth::user()->id)->get();
        return view('tv.edit-modal', compact('video','ads'));
    }

    public function del_video_body($id)
    {
        $video = Videos::find($id);
        return view('tv.remove-modal', compact('video'));
    }

    public function add_video_body()
    {
        $ads = Advertising::where('user_id',Auth::user()->id)->get();
        return view('tv.create-modal', compact('ads'));
    }

    public function add_stream_body(Request $request)
    {
        $url = $request->input('url');
        return view('tv.create-modal', compact('video','url'));
    }

    public function switchChannelBroadcasting(){
        $channel = Channel::where('id', Auth::user()->channel_id)->first();
        if($channel->published === 0){
            $channel->published = true;
            $channel->save();
            return 'Yes! you are now broadcasting';
        }
        else{
            $channel->published = false;
            $channel->save();
            return 'Your channel stopped broadcasting';
        }
    }

    public function switchLoop(){
        $channel = Channel::where('id', Auth::user()->channel_id)->first();
        if($channel->is_loop === 1) $channel->is_loop = 0;
        else $channel->is_loop = 1;
        $channel->save();
        return 'success';
    }

/*----------------*/

    public function update_video(Request $request, $id)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required'
        ));

        //store in database
        $video = Videos::find($id);

        if($request->has('ads')){
            if($request->input('ads') !== "null") $video->ads_id = $request->input('ads');
            else $video->ads_id = 0;
        }
        $video->title = $request->input('title');
        $video->description =Purifier::clean($request->input('description'));
        $video->url = $request->input('url');
//        $video->start_time = $this->edit_timezone($request->input('start_time'), false);
//        $video->end_time = $this->edit_timezone($request->input('end_time'), false);


        $video->save();

        Session::flash('success', 'Your change was successfully added!');

        //redirect

        return redirect()->route('videos.index', $video->id);
    }


    public function edit_timezone($val, $task)
    {

        $ipaddress = $_SERVER['REMOTE_ADDR'];

        if($ipaddress == '127.0.0.1'){

            $ipaddress = '95.140.192.60';

        } 

        $my_ip = file_get_contents('http://freegeoip.net/json/' . $ipaddress);

        $timezone_by_ip = json_decode($my_ip,true)['time_zone'];
//        $timezone_by_ip = 'Asia/Yerevan';

        switch ($task){

            case true:

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $val, 'UTC');

                $date->setTimezone($timezone_by_ip);

                return $date->toDateTimeString();

                break;

            case false:

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $val, $timezone_by_ip);

                $date->setTimezone('UTC');

                return $date->toDateTimeString();

                break;

        }


    }

    public function ads(Request $request)
    {

        $video = Videos::find($request->video_id);
        $video->ads_id = $request->ads_id;
        $res = $video->save();

        echo($res);
        exit;
    }

    public function editGeoblocking(Request $request){
        $data = $request->input('geo');
        if(!empty($data)){
            $channel = Channel::find(Auth::user()->channel_id);
            if($channel->blacklist === null) $channel->blacklist = '';
            $geo = implode(",",$data);
            $channel->blacklist = $geo;
            $channel->save();
        }
        return 'success';
    }

    public function reorderVideos(Request $request){
        $data = $request->input('order');
        $videos = Videos::where([['channel_id',Auth::user()->channel_id],['o_num','<>',0]])->orderBy('o_num','asc')->get(['id', 'o_num'])->toArray();;
        $res = [];
        if(count($data) > 1){
            foreach($data as $iter => $elem){
                $id = $videos[intval($elem) - 1]['id'];
                DB::table('videos')->where('id', $id)->update(['o_num' => $iter+1]);
                $res[] = $videos[intval($elem) - 1]['o_num'].'--'.($iter+1);
            }
            $this->reorderPlaylist();
        }
        return $res;
    }

    public function reorderPlaylist(){
        $videos = Videos::where([['channel_id',Auth::user()->channel_id],['o_num','<>',0]])->orderBy('o_num','asc')->get();
        $channel = Channel::find(Auth::user()->channel_id);
        foreach ($videos as $video){
            if($video->o_num === 1){
                $start = $channel->start_time;
                $end = $this->calculateEndTime($start, $video->start_time, $video->end_time);
            }
            else{
                $start = Videos::where([['channel_id',Auth::user()->channel_id],['o_num',($video->o_num - 1)]])->first()->end_time;
                $end = $this->calculateEndTime($start, $video->start_time, $video->end_time);
            }
            DB::table('videos')->where('id', $video->id)->update(['end_time' =>$end, 'start_time' => $start]);
        }
        $videos = Videos::where([['channel_id',Auth::user()->channel_id],['o_num','<>',0]])->orderBy('o_num','asc')->get();
        $res = [];
        foreach ($videos as $video){
            DB::table('videos')->where('id', $video->id)->update(['end_time' => $this->edit_timezone($video->end_time, false), 'start_time' => $this->edit_timezone($video->start_time, false)]);
//            $res[] = [$video->start_time, $video->end_time, $this->edit_timezone($video->start_time, false), $this->edit_timezone($video->end_time, false)];
        }
//        dd($res);
    }

    public function calculateEndTime($start_new, $start_time, $end_time){
        $start_new = Carbon::parse($start_new);
        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);
        $diff = $end->diffInSeconds($start);
        $end_new = $start_new->addSeconds($diff);
        return $end_new;
    }

    public function setChannelStart(Request $request){
        $channel = Channel::find(Auth::user()->channel_id);
        $start = $request->input('start_time');
        $channel->start_time = Carbon::parse($start);
        $channel->save();
        $this->reorderPlaylist();
        return redirect()->back();
    }

//    public function ads(Request $request)
//    {
//
//        $video = Videos::find($request->video_id);
//        $video->ads_id = $request->ads_id;
//        $res = $video->save();
//
//        echo($res);
//        exit;
//    }

//    public function ads_all(Request $request)
//    {
//        $channel = Channel::find($request->channel_id);
//        $channel->ads_id = $request->ads_id;
//        $channel->save();
//        $videos_res = Videos::where('channel_id', $request->channel_id)->update(['ads_id' =>  $request->ads_id]);
//        echo $videos_res;
//        exit;
//    }

//    public function ads_all_bg(Request $request)
//    {
//        $channel = Channel::find($request->channel_id);
//        $channel->bg_ads_id = $request->ads_id;
//        $channel->save();
//        echo 1;
//        exit;
//    }

//    public function edit_video_slide_pub(Request $request)
//    {
//
//        $video = Videos::where('id', $request->vidid)->first();
//        $video->slide_public = $request->event_pub;
//        $video->slide_title = $request->title;
//        $video->slide_desc = $request->desc;
//        $video->save();
//
//    }

}