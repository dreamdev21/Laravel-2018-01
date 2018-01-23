<?php

namespace App\Http\Controllers;

use App\Advertising;
use App\Channel;
use App\ChannelCategory;
use App\Coplay;
use App\Movie;
use App\Genre;
use App\Season;
use App\Serie;
use App\Videos;
use App\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Studio;
use App\Director;
use App\Actor;
use App\User;
use App\Follow;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Psr7\Stream;
use Carbon\Carbon;
class AdminUsersController extends Controller
{



    public function index()
    {

        $users = DB::table('users')
            ->leftjoin('studios','users.studio_id','=','studios.id')
            ->leftjoin('channels','users.channel_id','=','channels.id')
            ->select('users.*', 'studios.name', 'studios.percent', 'channels.title')
            ->where('users.id', '!=', 1)
            ->get();


        foreach($users as $user){
            if($user->last_login != null){
                $user->last_login = $this->edit_timezone($user->last_login, true);
            }
        }
        return view('admin.users.index', compact('users'));
    }

    public function exportCSV(){
        $users = User::where('role','<>',1)->get(['id','name','username','gender','phone','email','created_at',
            'updated_at','last_login','role','studio_id','ip','lat','lng','country']);

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['id','name','username','gender','phone','email','created_at',
            'updated_at','last_login','role','studio_id','ip','lat','lng','country']);

        foreach ($users as $user) {
            $csv->insertOne($user->toArray());
        }
        $csv->output('people.csv');
    }

    public function editUserRole(Request $request)
    {

        $st_percent = $request->st_percent;
        $st_name = $request->st_name;
        $user_id = $request->user_id;

        $stud_id = Studio::create([
            'name' => $st_name,
            'percent' => $st_percent
        ]);

        $user = User::where('id', $user_id)->first();
        $user->role = 2;
        $user->studio_id = $stud_id->id;
        $user->save();
        $usemail = $user->email;

        Mail::send('emails.prodelevate', ['user' => $user->name, 'studio' => $st_name], function ($message) use ($usemail) {
            $message->to($usemail)
                ->subject(' Studio Registration ');
        });

        return redirect()->back();
    }

    public function createProducerIndex(){
        return view('admin.users.createProducer');
    }

    public function createProducer(Request $request)
    {

        $st_percent = $request->st_percent;

        $st_name = $request->st_name;

        $stud_id = Studio::create([
            'name' => $st_name,
            'percent' => $st_percent
        ]);

        if($request->gender)
        {
            $avatar = 'male.jpg';
        }
        else
        {
            $avatar = 'female.png';
        }

        $reg_res = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'username'  => $request->username,
            'gender'    => $request->gender,
            'password'  => bcrypt($request->password),
            'slug'      => str_slug($request->name),
            'role'      => 2,
            'avatar'    => $avatar,
            'studio_id' => $stud_id->id
        ]);

        if($reg_res){
            $emailtext['name'] = $request->name;
            $emailtext['username'] = $request->username;
            $emailtext['email'] = $request->email;
            $emailtext['password'] = $request->password;
            $usemail = $emailtext['email'];


            Mail::send('emails.prodreg', ['name' => $emailtext['name'], 'username' => $emailtext['username'], 'email' => $emailtext['email'], 'password' => $emailtext['password']], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject(' Studio Registration ');
            });

        }

        return redirect('/admin/users');

    }

    public function createTvStationIndex(){
    $category = ChannelCategory::get();
        return view('admin.users.createTvStation',compact('category'));
    }

    public function createTvStation(Request $request){
//        dd($request->all());

        $this->validate($request, array(
            'email' => 'required|email|max:255|unique:users'
        ));


        if($request->gender)
        {
            $avatar = 'male.jpg';
        }
        else
        {
            $avatar = 'female.png';
        }

        $chan_res = Channel::create([
            'category_id' => $request->channel_cat_id,
            'title' => $request->chanelName,
            'ch_num' => $request->chanelNum
        ]);

        $reg_res = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'username'   => $request->username,
            'gender'     => $request->gender,
            'password'   => bcrypt($request->password),
            'slug'       => str_slug($request->name),
            'role'       => 4,
            'avatar'     => $avatar,
            'channel_id' => $chan_res->id
        ]);


        if($reg_res && $chan_res){


                $emailtext['name'] = $request->name;
                $emailtext['username'] = $request->username;
                $emailtext['email'] = $request->email;
                $emailtext['password'] = $request->password;
                $usemail = $emailtext['email'];


                Mail::send('emails.tvReg', ['name' => $emailtext['name'], 'username' => $emailtext['username'], 'email' => $emailtext['email'], 'password' => $emailtext['password']], function ($message) use ($usemail) {
                    $message->to($usemail)
                        ->subject(' TV station Registration ');
                });




        }

        return redirect('/admin/users');

    }

    public function delUser(Request $request)
    {
        $user_id = $request->uid;

        $user = User::where('id', $user_id)->first();

        if($user->role == 4){
            Advertising::where('user_id',$user_id)->delete();
            Videos::where('channel_id',$user->channel_id)->delete();
            Channel::where('id',$user->channel_id)->delete();
        }
        Follow::where('user_id', $user->id)->orwhere('follower_id', $user->id)->delete();

        Studio::where('id', $user->studio_id)->delete();

        $us_series = Serie::where('studio_id', $user->studio_id)->get();

        if($us_series){
            foreach($us_series as $ser){
                Season::where('series_id', $ser->id)->delete();
            }
            Serie::where('studio_id', $user->studio_id)->delete();
        }

        Movie::where('studio_id', $user->studio_id)->delete();

        Coplay::where('inv_to', $user->id)->orwhere('inv_from', $user->id)->delete();

        Watchlist::where('user_id', $user->id)->delete();

        $user->delete();

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

}