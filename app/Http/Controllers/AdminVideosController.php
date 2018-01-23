<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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

class AdminVideosController extends Controller
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

    public function index()
    {

        $channel_ids = [];
        $all_us_channels = User::select('channel_id')->get();

        foreach ($all_us_channels as $val){
            if($val->channel_id != null){
                $channel_ids[] = $val->channel_id;
            }
        }


        $ads = Advertising::get();
        $vide = Videos::orderBy('created_at', 'DESC')->whereNotIn('channel_id',$channel_ids)->paginate(12);

        foreach($vide as $vd){
            $currentDureation = $this -> time_Diff_Minutes($vd['start_time'],$vd['end_time']);

            $vd->start_time = $this->edit_timezone($vd['start_time'], true);
            $vd->end_time = $this->edit_timezone($vd['end_time'], true);
            $vd->dureation = gmdate('H:i:s',$currentDureation );
        }

        return view('admin.videos.index', compact('vide', 'ads'));
    }

    public function create(Request $request)
    {
        $prev_url = URL::previous();
        $channels = Channel::all();

        $data['channels'] = $channels;
        $data['prev_url'] = $prev_url;
        $expl = explode('/', $data['prev_url']);
        $data['segment'] = end($expl);
        return view('admin.videos.create', compact('data'));
    }

    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
            'channel_id' => 'required',
            'type' => 'required'
        ));

        $addedTime_h = $request->video_length_h;
        $addedTime_m = $request->video_length_m;
        $addedTime_s = $request->video_length_s;

        if(empty($addedTime_h) && empty($addedTime_m) && empty($addedTime_s)) return redirect()->back();

        if($addedTime_h == "")$addedTime_h= 0;
        if($addedTime_m == "")$addedTime_m= 0;
        if($addedTime_s == "")$addedTime_s= 0;



        //store in database
        $video = new Videos;

        /* Getting Start and end times */
        $max_end_time = Videos::where(['channel_id' => $request->channel_id])->max('end_time');

        $now = Carbon::now()->setTimezone('UTC')->toDateTimeString();

        if($now > $max_end_time || $max_end_time == null){
            $max_end_time = $now;
        }

//        $endTime = strtotime("+$request->video_length minutes", strtotime($max_end_time));
        $endTime = strtotime("+$addedTime_h hours $addedTime_m minutes $addedTime_s seconds", strtotime($max_end_time));
        $endTime = date("Y-m-d H:i:s", $endTime);
        $video->title  = $request->title;
        $video->description = Purifier::clean($request->description);
        $video->url = $request->url;
        $video->type = 'static'; //$request->type
        $video->start_time = $max_end_time;
        $video->end_time = $endTime;

        $video->channel_id = $request->channel_id;
        if(strpos($request->url, 'watch?v=')){
            $expl = explode('watch?v=', $request->url);
        }else{
            $expl = explode('/', $request->url);
        }
        $video->video_id = end($expl);
        $video->ads_id = 0;


        $video->save();

        Session::flash('success', 'The new video was successfully added!');

        //redirect
        return redirect()->route('videos.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $video = Videos::find($id);
        $video['start_time'] = $this->edit_timezone($video['start_time'], true);
        $video['end_time'] = $this->edit_timezone($video['end_time'], true);
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required'
        ));

        //store in database
        $video = Videos::find($id);

        $video->title = $request->input('title');
        $video->description =Purifier::clean($request->input('description'));
        $video->url = $request->input('url');
        $video->start_time = $this->edit_timezone($request->input('start_time'), false);
        $video->end_time = $this->edit_timezone($request->input('end_time'), false);

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

    public function ads_all(Request $request)
    {
        $channel = Channel::find($request->channel_id);
        $channel->ads_id = $request->ads_id;
        $channel->save();
        $videos_res = Videos::where('channel_id', $request->channel_id)->update(['ads_id' =>  $request->ads_id]);
        echo $videos_res;
        exit;
    }

    public function ads_all_bg(Request $request)
    {
        $channel = Channel::find($request->channel_id);
        $channel->bg_ads_id = $request->ads_id;
        $channel->save();
        echo 1;
        exit;
    }

    public function edit_video_slide_pub(Request $request)
    {

        $video = Videos::where('id', $request->vidid)->first();
        $video->slide_public = $request->event_pub;
        $video->slide_title = $request->title;
        $video->slide_desc = $request->desc;
        $video->save();

    }

    public function destroy($id)
    {
        $vide = Videos::find($id);
        $vide->delete();

        // redirect
        Session::flash('message', 'video Successfully deleted!');
        return redirect()->route('videos.index');
    }
}
