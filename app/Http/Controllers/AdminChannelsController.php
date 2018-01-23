<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Channel;
use App\Videos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Session;
use Intervention\Image\Facades\Image;
use Storage;
use App\Advertising;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests;

use Youtube;
use App\ChannelCategory;

class AdminChannelsController extends Controller
{

    public function index()
    {

        $continents = ["America","Europe","Australia","Asia","Africa"];
        //$live = Youtube::video(['https://www.youtube.com/watch?v=pCZeVTMEsik']);
        $ads = Advertising::get();
        $channels = Channel::orderBy('id', 'desc')->get();
        return view('admin.channels.index', compact('channels', 'continents', 'ads') );
    }

    public function channelData()
    {
        return view('admin.channels.get_data');
    }

    public function getChannels(Request $request)
    {
        if($request->all()){
            $req = $request->all();
            $channelCategories = ChannelCategory::all();
            $channel_url = $req['url'];
            $channel_info = Youtube::channel($channel_url);
            if(!empty((array)$channel_info)){
                $channel_id = $channel_info->__get('id');
                $channel_title = $channel_info->__get('title');
                $channel_description = $channel_info->__get('description');
                $channel_thumb = $channel_info->__get('default_thumb');
                $channel_url = 'https://www.youtube.com/channel/'.$channel_id;
                $channel_data = $channel_info->__get('videos');
                $playlist_id = $channel_info->__get('playlist_uploads');
                $channel_videos = $channel_data->get_videos();
                $playlist = Youtube::playlist('https://www.youtube.com/playlist?list='.$playlist_id)->__get('videos');
                $playlist_videos =$playlist->get_videos();

                foreach ($channel_videos as $key => $video){
                    $publishedAt = $video->snippet['publishedAt'];
                    $publishedAt = date('Y-m-d',strtotime($publishedAt));
                    $month_ago = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
                    $number_days = (strtotime($publishedAt) - strtotime($month_ago))  / (60 * 60 * 24);
                    if($number_days > 30){
                        unset($channel_videos[$key]);
                    }
                }
               $data = array(
                  'channel_id' =>   $channel_id,
                  'channel_title' =>   $channel_title,
                  'channel_description' =>   $channel_description,
                  'channel_thumb' =>   $channel_thumb,
                  'channel_url' =>   $channel_url,
                  'playlist_id' =>   $playlist_id,
                  'channel_videos' =>   $channel_videos,
                  'playlist_videos' =>   $playlist_videos,
                  'channelCategories' =>   $channelCategories
                );
                $html = view('admin.channels.channel_data', compact('data'));
                echo $html;die;
            }

        }
    }
    /*
     * Create video from admin
     * */
    public function createVideo(Request $request)
    {
        if($request->all()){
            $id = trim($request->id);
            $title = trim($request->title);
            $description = trim($request->description);
            $url = trim($request->url);
            $channel_id = trim($request->channel_id);
            $ch_id = Channel::where('ch_id', '=', $channel_id)->get()->toArray();
            $ch_id = $ch_id[0]['id'];
            $channel_title = trim($request->channel_title);
            $insert_data = array(
              'video_id' => $id,
              'title' => $title,
              'description' => $description,
              'url' => $url,
              'channel_id' => $ch_id,
              'channel_title' => $channel_title
            );
            $insert = Videos::create($insert_data);
            if(!empty($insert)){
                echo 1;die;
            }
//            $title = stripslashes();
        }
    }
    /*
   * Create channwl from admin
   * */
    public function createChannel(Request $request)
    {
        if($request->all()){
            $id = trim($request->id);
            $title = trim($request->channel_title);
            $description = trim($request->channel_description);
            $url = trim($request->channel_url);
            $channel_thumb = trim($request->channel_thumb);
            $channel_category = trim($request->channel_category);
            $insert_data = array(
                'ch_id' => $id,
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'logo' => $channel_thumb,
                'category_id' => $channel_category,
                'ads_id' => 0
            );
            $insert = Channel::create($insert_data);
            if(!empty($insert)){
                echo 1;die;
            }
        }
    }

    public function create(Request $request)
    {
        $channelCategories = ChannelCategory::all();
        return view('admin.channels.create', compact('channelCategories'));
    }

    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'title'             => 'required|max:255',
            'description'       => 'required',
            'category_id'       => 'required|integer',
            'ch_num'            => 'required|integer'
        ));

        //store in database
        $channel = new Channel;

        $channel->title              = $request->title;
        $channel->description        = Purifier::clean($request->description);
        $channel->category_id        = $request->category_id;
        $channel->ads_id             = 0;
        $channel->ch_num             = $request->ch_num;

//        if($request->hasFile('logo')){
//            $image = $request->file('logo');
//            $filename = time() . '.' . $image->getClientOriginalExtension();
//            $location = public_path('assets/images/' . $filename);
//            Image::make($image)->resize(800, 500)->save($location);
//
//            $channel->logo = $filename;
//        };

        $channel->save();

        Session::flash('success', 'The new channel was successfully added!');

        //redirect
        return redirect()->route('channels.show', $channel->id);
    }

    public function show($id)
    {
        $channel = Channel::find($id);
        return view('admin.channels.show', compact('channel'));
    }

    public function edit($id)
    {
        $channel = Channel::find($id);
        return view('admin.channels.edit', compact('channel'));
    }

    public function update(Request $request, $id)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'description' => 'required',
            'ch_num' => 'required|integer'
        ));

        //store in database

        $channel = Channel::find($id);

        $channel->ch_num = $request->ch_num;
        $channel->title = $request->input('title');
        $channel->description = Purifier::clean($request->input('description'));

        if($request->hasFile('logo')){
            $image = $request->file('logo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(800, 500)->save($location);

            $channel->logo = $filename;
        };

        $channel->save();

        Session::flash('success', 'Your change was successfully added!');

        //redirect

        return redirect()->route('channels.show', $channel->id);
    }

    public function editLoadingPointer(Request $request)
    {
        $this->validate($request, array(
            'img' => 'required|image'
        ));

        //store in database

        if($request->hasFile('img')){
            $image = $request->file('img');
            if(file_exists(public_path('assets/images/fv-logo-bg.gif'))){
                unlink(public_path('assets/images/fv-logo-bg.gif'));
            }
            $location = public_path('assets/images/fv-logo-bg.gif');
            Image::make($image)->save($location);
        };

        return redirect()->back();
    }

    public function deleteLoadingPointer(Request $request)
    {
//        $image = $request->file('img');
        unlink(public_path('assets/images/fv-logo-bg.gif'));
//        $location = public_path('assets/images/fv-logo-bg.gif');
//        Image::make($image)->save($location);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $channel = Channel::find($id);

        if(Auth::user()->role != 1){

            $user = User::where('channel_id', $channel->id)->first();
            $user_id = $user->id;

            if($user->role == 4){
                Advertising::where('user_id',$user_id)->delete();
                Videos::where('channel_id',$user->channel_id)->delete();
                User::where('channel_id', $channel->id)->delete();
            }

        }else{
                Videos::where('channel_id',$id)->delete();
        }

        $channel->delete();

        // redirect
        Session::flash('message', 'Channel Successfully deleted!');
        return redirect()->route('channels.index');
    }

    public function geoFencingChannel(Request $request){
        $cid = $request->id;


        $channel = Channel::where('id', $cid)->first();

//        dd($request->geo);
        if ($request->geo!=null){
            $geo = implode(",",$request->geo);
            $channel->blacklist = $geo;
        }else{
            $channel->blacklist = null;
        }
        $channel->save();

    }

    public function sendToFront(Request $request)
    {
        $channelId = $request->id;
        $oldChannelId =  Channel::select('id')->where('ch_to_front', 1)->first();

        Channel::where('ch_to_front', 1)->update(['ch_to_front' => 0]);

        $channel = Channel::find($channelId);

        if($channel->ch_to_front == 0){
            $channel->ch_to_front = 1;
        }
        else{
            $channel->ch_to_front = 0;
        }
        $channel->save();

        return Response::json(array(
            'success' => true,
            'oldId'   => $oldChannelId->id
        ));

    }

}