<?php

namespace App\Http\Controllers;

use App\Advertising;
use App\Channel;
use App\ChannelCategory;
use App\Coplay;
use App\Follow;
use App\Genre;
use App\Movie;
use App\Payment;
use App\Rate;
use App\Season;
use App\Serie;
use App\User;
use App\Videos;
use App\Watchlist;
use Carbon\Carbon;
use App\Post;
use App\PostCategory;
use Braintree_Configuration;
use Braintree_Transaction;
use Braintree_PaymentMethod;
use Braintree_Customer;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{

    public function __construct(Request $request)
    {
//        $token = $request->token;
//        $user  = User::where('api_token', $token)->first();
//        if($user == null) return false;
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user_res = User::where('email', $email)->first();
        if($user_res != null){
            $check_pass = Hash::check($password, $user_res->password);
            if($check_pass == true){
                $token = $this->generateRandomString();
                $user_res->api_token = $token;
                $user_res->save();
                echo json_encode($token);
            }
            else{
                $data['status'] = false;
                $data['message'] = 'wrong password';
                echo json_encode($data);
            }
        }
        else{
            $data['status'] = false;
            $data['message'] = 'wrong email';
            echo json_encode($data);

        }
    }

    public function register(Request $request){
        if($request->gender)
        {
            $avatar = 'male.jpg';
        }
        else
        {
            $avatar = 'female.png';
        }

        $ipaddress = $_SERVER['REMOTE_ADDR'];

        if($ipaddress == '127.0.0.1'){

//            $ipaddress = '95.140.192.60';
            $ipaddress = '41.63.191.255';

        }

        $my_ip = file_get_contents('http://freegeoip.net/json/' . $ipaddress);
        $latitude_by_ip = json_decode($my_ip,true)['latitude'];
        $longitude_by_ip = json_decode($my_ip,true)['longitude'];
        $country_code_by_ip = json_decode($my_ip,true)['country_code'];
        $country_name_by_ip = json_decode($my_ip,true)['country_name'];



        $exist_user_email = User::where('email', $request->email)->first();
        if(!empty($exist_user_email)){
            $data['status'] = false;
            $data['message'] = "this email is already taken";
            return json_encode($data);
        }

        $reg_res = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'gender'   => $request->gender,
            'password' => bcrypt($request->password),
            'slug'     => str_slug($request->name),
            'avatar'   => $avatar,
            'role'     => 3,
            'ip'       => $ipaddress,
            'api_token'=> $this->generateRandomString(),
            'lat'      => $latitude_by_ip,
            'lng'      => $longitude_by_ip,
            'country'  => $country_name_by_ip,
            'country_code'  => $country_code_by_ip
        ]);

        if($reg_res){

            $emailtext['name'] = $request->name;
            $emailtext['username'] = $request->username;
            $emailtext['email'] = $request->email;
            $usemail = $emailtext['email'];

            Mail::send('emails.reg', ['name' => $emailtext['name'], 'username' => $emailtext['username'], 'email' => $emailtext['email']], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Registration');
            });

        }

        $data['status'] = true;
        $data['token'] = $reg_res->api_token;
        echo json_encode($data);
    }

    public function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.'_'.round(microtime(true) * 1000);;
    }

    public function test()
    {
//        dd(12333);
        $data['status'] = true;
        $data['name'] = 'Test , it is a test message';

        echo json_encode($data);
    }

    public function UserData(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $data['id'] = $user->id;
        $data['status'] = true;
        $data['name'] = $user->name;
        $data['avatar'] = $user->avatar;
        $data['cover'] = $user->cover;
        $data['username'] = $user->username;
        $data['gender'] = $user->gender;
        $data['email'] = $user->email;
        $data['chat_history'] = ($user->chat_history === true ? 1 : 0);

        if ($user->braintree_id){
            $data['braintree_id'] = true;
        } else $data['braintree_id'] = false;

        if ($user->card_last_four){
            $data['card_last_four'] = $user->card_last_four;
        } else $data['card_last_four'] = false;

        if ($user->braintree_token){
            $data['braintree_token'] = true;
        } else $data['braintree_token'] = false;

        echo json_encode($data);
    }

    public function profile($name)
    {

        $user = User::where('username', $name)->first();
//        dd($user);
        $followers_res = [];
        $following_res = [];

        $fwers_res = Follow::where('follower_id', $user->id)->get();

        foreach ($fwers_res as $fwers_res_val){
            $followers_res[] = User::where('id', $fwers_res_val->user_id)->first();
        }

        $fwing_res = Follow::where('user_id', $user->id)->get();
        foreach ($fwing_res as $fwing_res_val){
            $following_res[] = User::where('id', $fwing_res_val->follower_id)->first();
        }
        $followers_res = count($followers_res);
        $following_res = count($following_res);


        $all_fol_users = [];
        $all_fol_usersApi = [];
        $fol_users = Follow::where('user_id', $user->id)->get();
        $count = 0;
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $user->id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
                $all_fol_usersApi[$count]['id']       = $all_fol_users[$count]['id'];
                $all_fol_usersApi[$count]['name']     = $all_fol_users[$count]['name'];
                $all_fol_usersApi[$count]['avatar']   = $all_fol_users[$count]['avatar'];
                $all_fol_usersApi[$count]['username'] = $all_fol_users[$count]['username'];
                $all_fol_usersApi[$count]['cover']    = $all_fol_users[$count]['cover'];
                $count++;
            }

        }
        $userData = [];
        $userData['id'] = $user->id;
        $userData['avatar'] = $user->avatar;
        $userData['cover'] = $user->cover;
        $userData['username'] = $user->username;

        $data['status'] = true;
        $data['user'] = $userData;
        $data['followers_res'] = $followers_res;
        $data['following_res'] = $following_res;
        $data['all_fol_usersApi'] = $all_fol_usersApi;
        echo json_encode($data);


    }

    public function settingPassChange(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();

        $usemail = $user->email;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $password_confirmation = $request->password_confirmation;


        if (!isset($oldPassword) || !isset($newPassword) || !isset($password_confirmation)) {
            $data['status'] = false;
            $data['message'] = 'Some of your fields are empty';
            echo json_encode($data);
        }
        else{
            if (!Hash::check($oldPassword, $user->password)) {
                $data['status'] = false;
                $data['message'] = 'Your current password is not correct';
                echo json_encode($data);
            }
            else{
                if ($newPassword != $password_confirmation) {
                    $data['status'] = false;
                    $data['message'] = 'passwords are not same';
                    echo json_encode($data);
                }
                else{
                    if (strlen($newPassword) < 4) {
                        $data['status'] = false;
                        $data['message'] = 'password must have minimum 4 character';
                        echo json_encode($data);
                    }
                    else{
                        $user->password = Hash::make($request->newPassword);
                        $user->save();

                        Mail::send('emails.passchange', [], function ($message) use ($usemail) {
                            $message->to($usemail)
                                ->subject('Change Password');
                        });
                        $data['status'] = true;
                        $data['message'] = 'Your password was successfully updated!';
                        echo json_encode($data);
                    }
                }
            }
        }

    }

    public function settingAvatarChange(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();

        if($request->hasFile('avatar')){

            $avatar = $request->file('avatar');
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png'];

            if(in_array($avatar->getClientOriginalExtension(), $img_val_array)){
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('assets/images/' . $filename));
                $user->avatar = $filename;
                $user->save();
                $data['status'] = true;
                $data['message'] = 'Your avatar has successfully updated!';
                echo json_encode($data);
            }
            else{
                $data['status'] = false;
                $data['message'] = 'incorrect file format!!';
                echo json_encode($data);
            }
        }
        else{
            $data['status'] = false;
            $data['message'] = 'file is required !!';
            echo json_encode($data);
        }
    }

    public function settingChatHistory(Request $request){
        $user = User::where('api_token',$request->token_custom)->first();

        if($user->chat_history == 0) $user->chat_history = 1;
        else $user->chat_history = 0;
        $user->save();

        $data['status'] = true;
        $data['message'] = 'chat history changed successfully';

        echo json_encode($data);
    }

    public function getChatHistoryStatus(Request $request){
        $user = User::where('api_token',$request->token_custom)->first();
        $data['status'] = true;
        $data['message'] = $user->chat_history;
        echo json_encode($data);
    }

    public function updateCoverImage(Request $request){
        $user = User::where('api_token',$request->token_custom)->first();

        if($request->hasFile('cover')){

            $cover = $request->file('cover');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->save( public_path('assets/images/' . $filename));


            if($user->cover != 'default_cover.jpg'){
                unlink(public_path('assets/images/' . $user->cover));
            }
            $user->cover = $filename;
            $user->save();
            $data['status'] = true;
            $data['message'] = 'Your cover has successfully updated!';
            echo json_encode($data);
        }
        else{
            $data['status'] = false;
            $data['message'] = 'file is required !!';
            echo json_encode($data);
        }
    }

    public function genres(){
        $genres = Genre:: select('id','name')->get();
        $data['status'] = true;
        $data['genres'] = $genres;

        echo json_encode($data);
    }

    public function movies(Request $request){

        $genres_id = $request->genres;
        $genres = Genre::where('id',$genres_id)->get();
        $movies = Movie::orderBy('created_at', 'DESC')->where('type','movie')->where('publish',1)->get();

        $ganre_list = [];
        $gan_mov    = [];
        foreach ($genres as $genre){
            foreach ($movies as $movie){
                $gids = $movie->genre_id;
                $gids = explode(',',$gids);

                foreach ($gids as $gid){

                    if( $genre->id == $gid){
                        $mov_qaq = Movie::where('id', $movie->id)->first();

                        $total_rates = Rate::where('movie_id', $movie->id)->get();

                        $rate_movie = 0;

                        if(count($total_rates) == 0){
                            $rate_movie = 0;
                        }
                        else{
                            $rate_movie = $total_rates->sum('rate') / $total_rates->count();
                        }

                        $mov_qaq->rate = $rate_movie;

                        $gan_mov[] = $mov_qaq;
                    }

                }
            }
            $gmarr['genre'] = $genre;
            $gmarr['movies'] = $gan_mov;
            $ganre_list[] = $gmarr;
            $gan_mov = [];
        }

        $data['status'] = true;
        $data['genres'] = $ganre_list;

        echo json_encode($data);
    }

    public function latestMovies(){
        $movies = Movie::orderBy('created_at', 'DESC')->where('publish',1)->where('type','movie')->take(40)->get();
        $data['status'] = true;
        $data['genres'] = $movies;
        echo json_encode($data);

    }

    public function latestSeries(){
        $series = Serie::orderBy('created_at', 'DESC')->where('type','serie')->take(40)->get();
        $data['status'] = true;
        $data['genres'] = $series;
        echo json_encode($data);

    }

    public function movie(Request $request){

        $slug = $request->slug;

        $user = User::where('api_token',$request->token_custom)->first();

//        $genres = Movie::where(['movies'])->get();

        $movies = Movie::with('parental')->where('slug', '=', $slug)->where('type', 'movie')->first();

        $rent = Payment::where('user_id', $user->id)->where('movie_id', $movies->id)->orderBy('id', 'desc')->first();

        $coplay_inv_count_res = false;

        if($rent){
            $coplay_inv_count_res = Coplay::where('payment_id', $rent->id)->where('inv_from',$user->id)->where('inv_mov_id', $movies->id)->count();

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $movies->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;

            $rental_id = $rent->id;
        }
        else{
            $rental = false;
            $rental_id = false;
        }

        $rate_user = null;
        $total_rates = Rate::where('movie_id', $movies->id)->get();

        if(count($total_rates) == 0){
            $rate_user = false;
            $rate_movie = false;
        }
        else{
            $rate_movie = $total_rates->sum('rate') / $total_rates->count();
            $rate_user  = Rate::where('user_id', $user->id)->first();
        }
        if($rate_user == null){
            $rate_user = false;
        }
        if($rate_movie == null){
            $rate_movie = false;
        }

        $us_fr_s = [];


        $all_fol_users = [];
        $fol_users = Follow::where('user_id', $user->id)->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id',$user->id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }

        }

        if($all_fol_users != null){

            foreach($all_fol_users as $fr_val){

                if($total_rates != null){

                    foreach ($total_rates as $rate_val){
                        if($fr_val->id == $rate_val->user_id){
                            $fr_val['rate'] = $rate_val->rate;
                            $us_fr_s[] = $fr_val;
                        }
                    }

                }

            }
        }
        $data['status'] = true;
        $data['movies'] = $movies;
        $data['rental'] = $rental;
        $data['rental_id'] = $rental_id;
        $data['coplay_inv_count_res'] = $coplay_inv_count_res;
        $data['rate_movie'] = $rate_movie;
        $data['rate_user'] = $rate_user;
        $data['us_fr_s'] = $us_fr_s;
        echo json_encode($data);


    }

    public function getTrailer(Request $request)
    {
        $trailer = Movie::select('trailer')->where('id', $request->movie_id)->first();
        $data['status'] = true;
        $data['trailer'] = $trailer;
        echo json_encode($data);

    }

    public function setRate(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $mid = $request->movie_id;
        $val = $request->value;

        $rate = new Rate;
        $rate->user_id    = $user->id;
        $rate->movie_id   = $mid;
        $rate->rate       = $val;
        $rate->save();

        $data['status'] = true;
        $data['message'] = 'you are rated successfully';
        echo json_encode($data);
    }

    public function series(){

        $genres = Genre::get();
        $series = Serie::orderBy('created_at', 'DESC')->where('type','serie')->get();
        $ganre_list = [];
        $gan_mov    = [];

        foreach ($genres as $genre){
            foreach ($series as $serie){
                $gids = $serie->genre_id;
                $gids = explode(',',$gids);

                foreach ($gids as $gid){
                    if( $genre->id == $gid){
                        $mov_qaq = Serie::where('id', $serie->id)->first();
                        $gan_mov[] = $mov_qaq;
                    }
                }
            }
            $gmarr['genre'] = $genre;
            $gmarr['series'] = $gan_mov;
            $ganre_list[] = $gmarr;
            $gan_mov = [];
        }

        $data['status'] = true;
        $data['genres'] = $ganre_list;
        echo json_encode($data);
    }

    public function series_detail(Request $request){

        $slug = $request->slug;
//        dd($slug);
        $user = User::where('api_token',$request->token_custom)->first();


        $series = Serie::where('slug', '=', $slug)->first();
        $series->genre;
        $rent = Payment::where('user_id', $user->id)->where('series_id', $series->id)->orderBy('id', 'desc')->first();

        $seasons = Season::where('series_id', $series->id)->get();
        $season_res = [];
        foreach ($seasons as $season){
            $season['movies'] = Movie::where('series_id', $series->id)->where('season_id', $season->id)->count();
            $season_res[] = $season;
        }

        if($rent){
            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $series->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;

        }
        else{
            $rental = false;
        }

        $data['status'] = true;
        $data['series'] = $series;
        $data['rental'] = $rental;
        $data['season_res'] = $season_res;
        echo json_encode($data);
    }

    public function season_detail(Request $request){

        $slug = $request->slug;
        $season_id = $request->season_id;

        $user = User::where('api_token',$request->token_custom)->first();

        $series = Serie::where('slug', '=', $slug)->first();
        $series->genre;

        $season = Season::where('series_id', $series->id)->where('id', $season_id)->first();

        $season['episodes'] = Movie::where('series_id', $series->id)->where('season_id', $season->id)->get();

        $rent = Payment::where('user_id', $user->id)->where('season_id', $season->id)->orderBy('id', 'desc')->first();


        if($rent){
            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $season->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;

        }
        else{
            $rental = false;
            $rent_series = Payment::where('user_id', $user->id)->where('series_id', $series->id)->orderBy('id', 'desc')->first();
            if($rent_series){
                $dt = Carbon::now();

                $curr_time = $dt->toDateTimeString();

                $period = $series->period * 60;

                $endTime = strtotime('+'.$period.' minutes', strtotime($rent_series->created_at->toDateTimeString()));

                $endTime = date("Y-m-d H:i:s", $endTime);

                $rental = $curr_time < $endTime;
            }
            else{
                $rental = false;
            }
        }

        $data['status'] = true;
        $data['series'] = $series;
        $data['rental'] = $rental;
        $data['season'] = $season;
        echo json_encode($data);

    }

    public function episode_details(Request $request)
    {

        $slug = $request->slug;
        $user = User::where('api_token',$request->token_custom)->first();

        $episode = Movie::where('slug', $slug)->where('type', 'serie')->first();
//        $wlist = Watchlist::where('user_id', $user->id)->get();

//        $wlist_res = false;
//        if(isset($wlist)){
//            foreach ($wlist as $wl){
//                if($wl->movie_id == $episode->id){
//                    $wlist_res = true;
//                }
//            }
//        }

        $rent = Payment::where('user_id', $user->id)->where('movie_id', $episode->id)->orderBy('id', 'desc')->first();

        $coplay_inv_count_res = false;

        if($rent){

            $coplay_inv_count_res = Coplay::where('payment_id', $rent->id)->where('inv_from', $user->id)->where('inv_mov_id', $episode->id)->count();

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $episode->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;

            $rental_id = $rent->id;
        }
        else{
            $rental = false;
            $rental_id = false;
            $rent_season = Payment::where('user_id', $user->id)->where('season_id', $episode->season_id)->orderBy('id', 'desc')->first();
            $seasone = Season::where('id', $episode->season_id)->first();
            if($rent_season){

                $coplay_inv_count_res = Coplay::where('payment_id', $rent_season->id)->where('inv_from',$user->id)->where('inv_mov_id', $episode->id)->count();

                $dt = Carbon::now();

                $curr_time = $dt->toDateTimeString();

                $period = $seasone->period * 60;

                $endTime = strtotime('+'.$period.' minutes', strtotime($rent_season->created_at->toDateTimeString()));

                $endTime = date("Y-m-d H:i:s", $endTime);

                $rental = $curr_time < $endTime;

                $rental_id = $rent_season->id;
            }
            else{
                $rental = false;
                $rental_id = false;
                $rent_series = Payment::where('user_id', $user->id)->where('series_id', $episode->series_id)->orderBy('id', 'desc')->first();
                $series = Serie::where('id', $episode->series_id)->first();
                if($rent_series){

                    $coplay_inv_count_res = Coplay::where('payment_id', $rent_series->id)->where('inv_from', $user->id)->where('inv_mov_id', $episode->id)->count();

                    $dt = Carbon::now();

                    $curr_time = $dt->toDateTimeString();

                    $period = $series->period * 60;

                    $endTime = strtotime('+'.$period.' minutes', strtotime($rent_series->created_at->toDateTimeString()));

                    $endTime = date("Y-m-d H:i:s", $endTime);

                    $rental = $curr_time < $endTime;

                    $rental_id = $rent_series->id;
                }
                else{
                    $rental = false;
                    $rental_id = false;
                }
            }

        }


        $rate_user = null;
        $total_rates = Rate::where('movie_id', $episode->id)->get();

        if(count($total_rates) == 0){
            $rate_user = false;
            $rate_movie = false;
        }
        else{
            $rate_movie = $total_rates->sum('rate') / $total_rates->count();
            $rate_user  = Rate::where('user_id', $user->id)->first();
        }
        if($rate_user == null){
            $rate_user = false;
        }
        if($rate_movie == null){
            $rate_movie = false;
        }

        $us_fr_s = [];


        $all_fol_users = [];
        $fol_users = Follow::where('user_id', $user->id)->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $user->id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }

        }

        if($all_fol_users != null){

            foreach($all_fol_users as $fr_val){

                if($total_rates != null){

                    foreach ($total_rates as $rate_val){
                        if($fr_val->id == $rate_val->user_id){
                            $fr_val['rate'] = $rate_val->rate;
                            $us_fr_s[] = $fr_val;
                        }
                    }

                }

            }
        }

        $data['status'] = true;
        $data['episode'] = $episode;
        $data['rental'] = $rental;
        $data['rental_id'] = $rental_id;
        $data['coplay_inv_count_res'] = $coplay_inv_count_res;
        $data['rate_movie'] = $rate_movie;
        $data['rate_user'] = $rate_user;
        $data['us_fr_s'] = $us_fr_s;
        echo json_encode($data);

    }

    public function liveTV(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();

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
        $last_watched_chan_id = $user->last_watched_video;
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
                if (strpos($a, $continent) !== false) {
//                    unset( $categories[$category_key]['channels'][$key] );
                    unset( $channels );
                    continue;
                }

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
        $data['status'] = true;
        $data = array(
            'categories' => $categories,
            'curr_time' => $curr_time
        );

        echo json_encode($data);
    }

    public function soPlay(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $slug = $request->slug;

        $movie = Movie::where('slug', $slug)->first();
        //change s3 bucket url to cloudfront url /start
        $movie_cloudfront_url = $movie->url;
        $save_test_movie_url = $movie->url;
        $movie_url_array =  explode('uploads/',$movie_cloudfront_url);
        $movie_cloudfront_url = implode('/',['http://dgrwwo8dynrvd.cloudfront.net/uploads',$movie_url_array[1]]);
        $movie->url =$movie_cloudfront_url;
        //change s3 bucket url to cloudfront url /end
        // cloudfornt set cookie  /start
        header('Access-Control-Allow-Origin: *');
        $resource = $movie->url;
        // default expiry after 5 seconds
        $movie_duration = (isset($movie->duration) ? $movie->duration : '1:00:00');
        $movie_duration_components = explode(':',$movie_duration);
        $movie_duration_hours =(int)$movie_duration_components[0];
        $movie_duration_min =(int)$movie_duration_components[1];
        $movie_duration_sec =(int)$movie_duration_components[2];
        $movie_duration_seconds = $movie_duration_hours*3600+$movie_duration_min*60+$movie_duration_sec;
        $expires = time() + $movie_duration_seconds;
        // key pair generated for cloudfront
        $keyPairId = 'APKAIKZ6O6LBPAOSLYNA';
        $json = '{"Statement":[{"Resource":"' . $resource . '","Condition":{"DateLessThan":{"AWS:EpochTime":' . $expires . '}}}]}';
        // read cloudfront private key pair
        $fp = fopen('pk-APKAIKZ6O6LBPAOSLYNA.pem', 'r');
        $priv_key = fread($fp, 8192);
//        $pkeyid = openssl_get_privatekey($priv_key);
        fclose($fp);

        // create the private key
        $key = openssl_get_privatekey($priv_key);
        // sign the policy with the private key
        // depending on your php version you might have to use
        // openssl_sign($json, $signed_policy, $key, OPENSSL_ALGO_SHA1)

        openssl_sign($json, $signed_policy, $key);

        openssl_free_key($key);
        // create url safe signed policy
        $base64_signed_policy = base64_encode($signed_policy);
        $signature = str_replace(array('+', '=', '/'), array('-', '_', '~'), $base64_signed_policy);

        // construct the url
        $url = $resource . '?Expires=' . $expires . '&Signature=' . $signature . '&Key-Pair-Id=' . $keyPairId;
        $movie->url =$url;
        // cloudfornt set cookie  /end

        $rent = Payment::where('user_id', $user->id)->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();

        if($rent){

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $movie->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;

        }
        else{
            $rental = false;

            $rent_season = Payment::where('user_id', $user->id)->where('season_id', $movie->season_id)->orderBy('id', 'desc')->first();
            $seasone = Season::where('id', $movie->season_id)->first();
            if($rent_season){
                $dt = Carbon::now();

                $curr_time = $dt->toDateTimeString();

                $period = $seasone->period * 60;

                $endTime = strtotime('+'.$period.' minutes', strtotime($rent_season->created_at->toDateTimeString()));

                $endTime = date("Y-m-d H:i:s", $endTime);

                $rental = $curr_time < $endTime;

            }
            else{
                $rental = false;

                $rent_series = Payment::where('user_id', $user->id)->where('series_id', $movie->series_id)->orderBy('id', 'desc')->first();
                $series = Serie::where('id', $movie->series_id)->first();
                if($rent_series){
                    $dt = Carbon::now();

                    $curr_time = $dt->toDateTimeString();

                    $period = $series->period * 60;

                    $endTime = strtotime('+'.$period.' minutes', strtotime($rent_series->created_at->toDateTimeString()));

                    $endTime = date("Y-m-d H:i:s", $endTime);

                    $rental = $curr_time < $endTime;

                }
                else{
                    $rental = false;
                }
            }

        }

        if(!$rental){
            $data['status'] = false;
            $data['massage'] = 'there are no rent information';
            echo json_encode($data);
            exit;
        }

            function generateRandomString($length = 40) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

            $vtoken = generateRandomString();

            Session::set('vtoken', $vtoken);

            $hide_ads = true;

            $data['status'] = true;
            $data['movie'] = $movie;
            $data['rental'] = $rental;
            $data['vtoken'] = $vtoken;
            $data['url'] = $url;
            $data['hide_ads'] = $hide_ads;
            echo json_encode($data);
    }

    public function controlWatchlist(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $watchlist = new Watchlist;
        $wlControl = Watchlist::where('user_id', $user->id)->where('movie_id', $request->movie_id)->first();

        if($wlControl){
            $wlControl->delete();
            $data['status'] = true;
            $data['message'] = 'Movie successfully deleted from watchlist';
            echo json_encode($data);
            exit;
        }

        $watchlist->user_id = $user->id;
        $watchlist->movie_id = $request->movie_id;
        $watchlist->save();
        $data['status'] = true;
        $data['message'] = 'Movie successfully added to watchlist';
        echo json_encode($data);
    }

    public function delWatchlist(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $wldel = Watchlist::where('user_id', $user->id)->where('movie_id', $request->del_movieId)->first();
        $wldel_res = $wldel->delete();

        $data['status'] = true;
        $data['message'] = 'Movie successfully deleted from watchlist';
        echo json_encode($data);
    }

    public function clientToken(){

        $data['status'] = true;
        $data['brain_tree_token'] = \Braintree_ClientToken::generate();
        echo json_encode($data);
    }

    public function showFollowers(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $followers_res = [];
        $following_res = [];

        $fwers_res = Follow::where('follower_id', $user->id)->get();

        foreach ($fwers_res as $fwers_res_val){
            $followers_res[] = User::where('id', $fwers_res_val->user_id)->first();
        }


        $fwing_res = Follow::where('user_id', $user->id)->get();
        foreach ($fwing_res as $fwing_res_val){
            $following_res[] = User::where('id', $fwing_res_val->follower_id)->first();
        }



        $data['status'] = true;
        $data['followers_res'] = $followers_res;
        $data['following_res'] = $following_res;
        echo json_encode($data);
    }

    public function search(Request $request)
    {

        $search_res = array();
        $search_words = $request->search_words;
        $search_res['titles'] = Movie::select('slug', 'title', 'poster', 'type')->where('title', 'LIKE', '%'.$search_words.'%')->take(5)->get();
        $search_res['users'] = User::select('id', 'username', 'avatar')->where('name', 'LIKE', '%'.$search_words.'%')->where('role', '!=', 2)->where('role', '!=', 4)->where('role', '!=', 1)->take(5)->get();

        $data['status'] = true;
        $data['searchRes'] = $search_res;
        echo json_encode($data);
    }

    public function searchCoPlay(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();
        $search_words = $request->search_words;

        function chat_res($search_words,$user)
        {
            $all_fol_users = [];
            $fol_users = Follow::where('user_id', $user->id)->get();
            foreach ($fol_users as $val){
                $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $user->id)->first();

                if(!empty($get_fr->user_id)){
                    $all_fol_users[] = User::select('id', 'username', 'avatar')->where('id', $get_fr->user_id)->where('username', 'LIKE', '%'.$search_words.'%')->first();
                }

            }
            return $all_fol_users;
        }

        $search_res = chat_res($search_words,$user);

        if(empty($search_res)){
            $search_res = '';
        }


        $data['status'] = true;
        $data['search_res'] = $search_res;
        echo json_encode($data);
    }

    public function userPhone(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();

        $phone_number = preg_replace( '/[^0-9]/', '', $request->phone );
        $ch_phone = User::where('phone', $phone_number)->first();
        if($ch_phone == null) {
            $user->phone = $phone_number;
            $user->save();
        }
        $data['status'] = true;
        $data['message'] = 'user phone number saved successfully';
        echo json_encode($data);

    }

    public function followById(Request $request)
    {

        $authUser = User::where('api_token',$request->token_custom)->first();
        $user = User::find($request->userToFol_id);

        if ($authUser->canFollow($user)) {
            $authUser->following()->attach($user);

            $all_f_list = $this->chat_res($authUser);
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $url = env('APP_URL').':3000/follow';
            $data = array(
                'event' => 'follow',
                'f_user_fr' => $all_f,
                'f_u_id' => $user->id,
                'f_u_avatar' => $user->avatar,
                'f_u_username' => $user->username,
                'from_u_id' => $authUser->id,
                'from_u_username' => $authUser->username,
                'from_u_avatar' => $authUser->avatar
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);

            $data['status'] = true;
            $data['message'] = 'You started following successfully';
            echo json_encode($data);
            exit;
        }

        $data['status'] = false;
        $data['message'] = 'following is not successful';
        echo json_encode($data);
    }

    public function unFollow(Request $request )
    {
        $authUser = User::where('api_token',$request->token_custom)->first();
        $user = User::find($request->userToUnfol_id);

        if ($authUser->canUnfollow($user)) {
            $authUser->following()->detach($user);

            $data['status'] = true;
            $data['message'] = 'unFollow is success';
            echo json_encode($data);
            exit;
        }

        $data['status'] = false;
        $data['message'] = 'unFollow is not success';
        echo json_encode($data);
    }

    public function cancelMembership(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();

        $usemail = $user->email;

        if ($user->delete()) {


            Mail::send('emails.cmship', [], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Cancel Membership');
            });

            $data['status'] = true;
            $data['message'] = 'user successfully deleted';
            echo json_encode($data);
        }

    }

    public function rentingProcess(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();

        $amount  = $request['amount'];
        $paymentMethodNonce   = $request['payment_method_nonce'];
        $result = '';

        if($request->save == 'on'){

            $crate_c_result = Braintree_Customer::create([
                'firstName' => $user->username,
                'email' => $user->email,
            ]);

            if($crate_c_result->success){

                $create_pm_result = Braintree_PaymentMethod::create(
                    [
                        'paymentMethodNonce' => $paymentMethodNonce,
                        'customerId' => $crate_c_result->customer->id,
                        'options' => ['verifyCard' => true]
                    ]
                );

                $newPaymentMethodToken = $create_pm_result->paymentMethod->token;

                $result = Braintree_Transaction::sale(
                    [
                        'amount' => $amount,
                        'paymentMethodToken' => $newPaymentMethodToken,
                        'options' => [
                            'submitForSettlement' => True,
                            'storeInVaultOnSuccess' => True
                        ]
                    ]
                );

                $last4 = $create_pm_result->paymentMethod->last4;
                $braintree_id = $create_pm_result->paymentMethod->customerId;

                $user->braintree_id = $braintree_id;
                $user->card_last_four = $last4;
                $user->braintree_token = $newPaymentMethodToken;
                $user->save();

            }

        }
        else{
            $result = Braintree_Transaction::sale(
                [
                    'amount' => $amount,
                    'paymentMethodNonce' => $paymentMethodNonce,
                    'options' => [
                        'submitForSettlement' => True,
                        'storeInVaultOnSuccess' => True
                    ]
                ]
            );
        }

        if ($result->success) {
            $all_f_list = $this->chat_res($user);
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $mov_name = Movie::select('title')->where('id', $request->cd__36698__1WWWm)->first();
            $payment = new Payment;
            $payment->user_id = $user->id;
            $payment->transaction_id = $result->transaction->id;
            if(isset($request->cd__36698__1WWWm)){
                $payment->movie_id = $request->cd__36698__1WWWm;
            }
            if(isset($request->cd__36725__1WWWm)){
                $payment->series_id = $request->cd__36725__1WWWm;
            }
            if(isset($request->cd__39165__1WWWm)){
                $payment->series_id = $request->cd__39165__1WWWm;
            }
            $payment->amount = $result->transaction->amount;
            $payment->save();


            if(isset($request->cd__36698__1WWWm)){

                $url = env('APP_URL').':3000/rent';
                $data = array(
                    'event' => 'rent',
                    'r_user_id' => $user->id,
                    'r_user_avatar' => $user->avatar,
                    'r_user_username' => $user->username,
                    'r_user_fr' => $all_f,
                    'r_movie_id' => $request->cd__36698__1WWWm,
                    'r_movie_title' => $mov_name->title,
                );

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);
                file_get_contents($url, false, $context);

            }

            $dataApi['status'] = true;
            $dataApi['message'] = 'payment pass successfully ';
            echo json_encode($dataApi);
            exit;

        }else{

            $dataApi['status'] = true;
            $dataApi['message'] = 'payment pass successfully ';
            echo json_encode($dataApi);

        }
    }

    public function rentingProcessWithSavedPayment(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();
        $amount  = $request['amount'];

        $result = Braintree_Transaction::sale([
            'amount' => $amount,
            'customerId' => $user->braintree_id,
            'paymentMethodToken' =>  $user->braintree_token,
            'options' => [
                'submitForSettlement' => True,
                'storeInVaultOnSuccess' => True
            ]
        ]);

        if ($result->success) {
            $all_f_list = $this->chat_res($user);
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $payment = new Payment;
            $payment->user_id = $user->id;
            $payment->transaction_id = $result->transaction->id;

            if(isset($request->cd__36698__1WWWm)){
                $mov_name = Movie::select('title')->where('id', $request->cd__36698__1WWWm)->first();
                $payment->movie_id = $request->cd__36698__1WWWm;
            }
            if(isset($request->cd__36725__1WWWm)){
                $payment->series_id = $request->cd__36725__1WWWm;
            }
            if(isset($request->cd__39165__1WWWm)){
                $payment->season_id = $request->cd__39165__1WWWm;
            }

            $payment->amount = $result->transaction->amount;
            $payment->save();


            if(isset($request->cd__36698__1WWWm)) {
                $url = env('APP_URL') . ':3000/rent';
                $data = array(
                    'event'           => 'rent',
                    'r_user_id'       => $user->id,
                    'r_user_avatar'   => $user->avatar,
                    'r_user_username' => $user->username,
                    'r_user_fr'       => $all_f,
                    'r_movie_id'      => $request->cd__36698__1WWWm,
                    'r_movie_title'   => $mov_name->title,
                );

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context = stream_context_create($options);
                file_get_contents($url, false, $context);
            }

            $dataApi['status'] = true;
            $dataApi['message'] = 'payment pass successfully ';
            echo json_encode($dataApi);
            exit;
        }else{
            $dataApi['status'] = true;
            $dataApi['message'] = 'payment pass successfully ';
            echo json_encode($dataApi);
            exit;
        }
    }

    public function sendCoPlayInv(Request $request)
    {
        $user = User::where('api_token',$request->token_custom)->first();

        $user_id                  = $user->id;
        $movie_id                 = $request->m_id;
        $payment_id               = $request->p_id;
        $invi_users_id            = $request->inv_u_id;
        $coplay_inv_count_res     = false;
        $endTime                  = '';


        $movie = Movie::where('id', $movie_id)->first();

        if($movie->type == "movie"){
            $rent = Payment::where('user_id', $user_id)->where('movie_id', $movie_id)->orderBy('id', 'desc')->first();

            $coplay_inv_res = Coplay::where('payment_id', $payment_id)->where('inv_from', $user_id)->where('inv_mov_id', $movie_id)->count();

            if($coplay_inv_res != 0){
                $dataApi['status'] = false;
                $dataApi['message'] = '4001';
                echo json_encode($dataApi);
                exit;
            }

            if($rent) {

                $period = 5;

                $dt = Carbon::now();

                $curr_time = $dt->toDateTimeString();

                $endTime = strtotime('+'.$period.' minutes', strtotime($curr_time));

                $endTime = date("Y-m-d H:i:s", $endTime);

            }

            $all_f_username = [];

            foreach ($invi_users_id as $val){

                $coplay_inv_count_res = Coplay::where('payment_id', $payment_id)->where('inv_from', $user_id)->where('inv_mov_id', $movie_id)->count();

                if($coplay_inv_count_res >= 4){
//                    echo $coplay_inv_count_res;
                    $dataApi['status'] = false;
                    $dataApi['coplay_invite_count'] = $coplay_inv_count_res;
                    $dataApi['massage'] = 'coplay invite count greater than 4';
                    echo json_encode($dataApi);
                    exit;
                }
                $coplay               = new Coplay;
                $coplay->inv_mov_id   = $movie_id;
                $coplay->payment_id   = $payment_id;
                $coplay->inv_from     = $user_id;
                $coplay->exp_date     = $endTime;
                $coplay->inv_to       = $val;
                $coplay->save();

                $usnmtemp = User::select('username')->where('id', $val)->first();

                $all_f_username[] = $usnmtemp->username;

            }



            $movie = Movie::where('id', $movie_id)->first();

            $all_f_username = implode(",", $all_f_username);
            $all_f = implode(",", $invi_users_id);



            $url = env('APP_URL').':3000/coplay';
            $data = array(
                'event' => 'coplay',
                'cp_u_from' => $user->id,
                'cp_u_avatar' => $user->avatar,
                'cp_u_to' => $all_f,
                'cp_u_to_username' => $all_f_username,
                'cp_u_username' => $user->username,
                'cp_m_title' => $movie->title,
                'cp_m_slug' => $movie->slug
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);




            $dataApi['status'] = true;
            $dataApi['coplay_invite_count'] = 4 - ++$coplay_inv_count_res;
            echo json_encode($dataApi);
            exit;
        }
        else{


            $rent = Payment::where('id', $payment_id)->orderBy('id', 'desc')->first();

            $coplay_inv_res = Coplay::where('payment_id', $payment_id)->where('inv_from', $user_id)->where('inv_mov_id', $movie_id)->count();

            if($coplay_inv_res != 0){
                $dataApi['status'] = false;
                $dataApi['message'] = '4001';
                echo json_encode($dataApi);
                exit;
            }

            if($rent) {

                $period = 5;

                $dt = Carbon::now();

                $curr_time = $dt->toDateTimeString();

                $endTime = strtotime('+'.$period.' minutes', strtotime($curr_time));

                $endTime = date("Y-m-d H:i:s", $endTime);

            }

            $all_f_username = [];

            foreach ($invi_users_id as $val){

                $coplay_inv_count_res = Coplay::where('payment_id', $payment_id)->where('inv_from', $user_id)->where('inv_mov_id', $movie_id)->count();

                if($coplay_inv_count_res >= 4){
                    $dataApi['status'] = false;
                    $dataApi['coplay_invite_count'] = $coplay_inv_count_res;
                    $dataApi['massage'] = 'coplay invite count greater than 4';
                    echo json_encode($dataApi);
                    exit;
                }
                $coplay               = new Coplay;
                $coplay->inv_mov_id   = $movie_id;
                $coplay->payment_id   = $payment_id;
                $coplay->inv_from     = $user_id;
                $coplay->exp_date     = $endTime;
                $coplay->inv_to       = $val;
                $coplay->save();

                $usnmtemp = User::select('username')->where('id', $val)->first();

                $all_f_username[] = $usnmtemp->username;

            }



            $movie = Movie::where('id', $movie_id)->first();

            $all_f_username = implode(",", $all_f_username);
            $all_f = implode(",", $invi_users_id);



            $url = env('APP_URL').':3000/coplay';
            $data = array(
                'event' => 'coplay',
                'cp_u_from' => $user->id,
                'cp_u_avatar' => $user->avatar,
                'cp_u_to' => $all_f,
                'cp_u_to_username' => $all_f_username,
                'cp_u_username' => $user->username,
                'cp_m_title' => $movie->title,
                'cp_m_slug' => $movie->slug
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);


            $dataApi['status'] = true;
            $dataApi['coplay_invite_count'] = 4 - ++$coplay_inv_count_res;
            echo json_encode($dataApi);
            exit;

        }
    }

    public function coPlay(Request $request){

        $user = User::where('api_token',$request->token_custom)->first();
        $slug = $request->slug;
        $hide_ads = true;
        $movie = Movie::where('slug', $slug)->first();

        function encryptIt($uid, $mid, $pid) {
            return $uid.'__ROOM__'.$mid.'_P'.$pid;
        }

        if($movie->type == 'serie'){
            //SERIES
            $rent = Payment::where('user_id', $user->id)->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();

            if($rent){

                $dt = Carbon::now();

                $curr_time     = $dt->toDateTimeString();

                $period        = $movie->period * 60;

                $endTime       = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

                $endTime       = date("Y-m-d H:i:s", $endTime);

                $rental        = $curr_time < $endTime;

                $room_id = encryptIt($user->id, $movie->id, $rent->id);

            }
            else{
                $rental = false;
                $rent_season = Payment::where('user_id', $user->id)->where('season_id', $movie->season_id)->orderBy('id', 'desc')->first();
                $seasone = Season::where('id', $movie->season_id)->first();
                if($rent_season){
                    $dt = Carbon::now();

                    $curr_time     = $dt->toDateTimeString();

                    $period        = $seasone->period * 60;

                    $endTime       = strtotime('+'.$period.' minutes', strtotime($rent_season->created_at->toDateTimeString()));

                    $endTime       = date("Y-m-d H:i:s", $endTime);

                    $rental        = $curr_time < $endTime;

                    $room_id = encryptIt($user->id, $movie->id, $rent_season->id);
                }
                else{
                    $rental = false;
                    $rent_series = Payment::where('user_id', $user->id)->where('series_id', $movie->series_id)->orderBy('id', 'desc')->first();
                    $series = Serie::where('id', $movie->series_id)->first();
                    if($rent_series){
                        $dt = Carbon::now();

                        $curr_time     = $dt->toDateTimeString();

                        $period        = $series->period * 60;

                        $endTime       = strtotime('+'.$period.' minutes', strtotime($rent_series->created_at->toDateTimeString()));

                        $endTime       = date("Y-m-d H:i:s", $endTime);

                        $rental        = $curr_time < $endTime;

                        $room_id = encryptIt($user->id, $movie->id, $rent_series->id);
                    }
                    else{
                        $rental = false;
                    }
                }
            }

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $coplay_res = Coplay::where('inv_to', $user->id)->where('inv_mov_id', $movie->id)->where('usm', 0)->where('exp_date', '>', $curr_time)->first();
            $coplay = $coplay_res;
            if($coplay_res){
                $room_id = encryptIt($coplay_res->inv_from, $movie->id, $coplay_res->payment_id);

            }

            if(!$rental && !$coplay){
                $dataApi['status'] = false;
                $dataApi['message'] = 'you are not rental and coplay person';
                echo json_encode($dataApi);
                exit;
            }



            $dataApi['status'] = true;
            $dataApi['movie'] = $movie;
            $dataApi['room_id'] = $room_id;
            $dataApi['rental'] = $rental;
            $dataApi['hide_ads'] = $hide_ads;
            echo json_encode($dataApi);
            exit;

        }
        else{
            $rent = Payment::where('user_id', $user->id)->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();

            if($rent){

                $dt = Carbon::now();

                $curr_time     = $dt->toDateTimeString();

                $period        = $movie->period * 60;

                $endTime       = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

                $endTime       = date("Y-m-d H:i:s", $endTime);

                $rental        = $curr_time < $endTime;

                $room_id = encryptIt($user->id, $movie->id, $rent->id);

            }
            else{
                $rental = false;
            }

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $coplay_res = Coplay::where('inv_to', $user->id)->where('inv_mov_id', $movie->id)->where('usm', 0)->where('exp_date', '>', $curr_time)->first();
            $coplay = $coplay_res;
            if($coplay_res){
                $room_id = encryptIt($coplay_res->inv_from, $movie->id, $coplay_res->payment_id);

            }

            if(!$rental && !$coplay){
                $dataApi['status'] = false;
                $dataApi['message'] = 'you are not rental and coplay person';
                echo json_encode($dataApi);
                exit;
            }

            $dataApi['status'] = true;
            $dataApi['movie'] = $movie;
            $dataApi['room_id'] = $room_id;
            $dataApi['rental'] = $rental;
            $dataApi['hide_ads'] = $hide_ads;
            echo json_encode($dataApi);
            exit;
        }
    }

    public static function chat_res($authUser)
    {
        $all_fol_users = [];
        $fol_users = Follow::where('user_id', $authUser->id)->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $authUser->id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }
        }
        return $all_fol_users;
    }

    public function checkFollow(Request $request)
    {
        $user_id = User::where('api_token',$request->token_custom)->first()->id;
        return json_encode(Follow::where('user_id',$user_id)->where('follower_id', $request->from_id)->first());
    }

    public function getWatchlist(Request $request){
        $user_id = User::where('api_token',$request->token_custom)->first()->id;
        $watchlist = Watchlist::where('user_id', $user_id)->get();
        $list = array();
        if(!empty($watchlist)){
            foreach ($watchlist as $elem){
                $movie = Movie::find($elem->movie_id)->toArray();
                if(!empty($movie))$list[] = $movie;
            }
        }
        return json_encode($list);
    }

    public function checkRented(Request $request){
        $slug = $request->slug;
        $id = $user_id = User::where('api_token',$request->token_custom)->first()->id;
        $movie = Movie::with('parental')->where('slug', '=', $slug)->where('type', 'movie')->first();
        $duration[] = explode(':',$movie->duration);
        $duration = $duration[0][0].'h'.$duration[0][1].'m';
        $movie->duration = $duration;
        $rent = Payment::where('user_id', $id)->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();
        if($rent){
            $dt = Carbon::now();
            $curr_time = $dt->toDateTimeString();
            $period = $movie->period * 60;
            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));
            $endTime = date("Y-m-d H:i:s", $endTime);
            $rental = $curr_time < $endTime;
        }
        else $rental = false;
        return json_encode(['rented' => $rental]);
    }

    public function getNews()
    {
        $news = PostCategory::get();
        foreach ($news as $key => $val){
            $news[$key]->posts = Post::where('category_id', $val->id)->limit(10)->get();
        }
        return json_encode(['news' => $news]);
    }

    public function getLatestNews(){
        $last_news = Post::orderBy('created_at', 'desc')->limit(5)->get();
        return json_encode(['latestNews' => $last_news]);
    }

    public function getCategoryNews(Request $request){

        $category_id = $request->categoryId;

        $category_news = Post::orderBy('created_at', 'desc')->where('category_id', $category_id)->get();
        return json_encode(['categoryNews' => $category_news]);
    }

    public function test999()
    {

    }

    public function movieFriendList(Request $request)
    {
        $user_id = $user = User::where('api_token',$request->token_custom)->first()->id;
        $movie_id = $request->movie_id;
        $all_fol_users = [];
        $all_user_list = [];
        $fol_users = Follow::where('user_id', $user_id)->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $user_id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }

        }


        foreach ($all_fol_users as $val){
            if(Payment::where('user_id', $val->id)->where('movie_id', $movie_id)->count() != 0){
                $all_user_list[] = $val;
            }
        }
        return json_encode(['movieWatchedUsers' => $all_user_list]);
    }


    public function rentPayPal(Request $request)
    {
        $user_id        = $request->user_id;
        $movie_id       = $request->movie_id;
        $amount         = $request->amount;
        $transaction_id = $request->transaction_id;
        $authUser = User::where('api_token',$request->token_custom)->first();

        $all_f_list = $this->chat_res($authUser);

        $all_f = [];
        foreach ($all_f_list as $val){
            $all_f[] = $val->id;
        }
        $all_f = implode(",", $all_f);

        $mov_name = Movie::select('title')->where('id', $movie_id)->first();
        $payment                 = new Payment;
        $payment->user_id        = $user_id;
        $payment->transaction_id = $transaction_id;
        $payment->movie_id       = $movie_id;
        $payment->amount         = $amount;
        $payment->save();

        $url = env('APP_URL').':3000/rent';
        $data = array(
            'event' => 'rent',
            'r_user_id' => $authUser->id,
            'r_user_avatar' => $authUser->avatar,
            'r_user_username' => $authUser->username,
            'r_user_fr' => $all_f,
            'r_movie_id' => $movie_id,
            'r_movie_title' => $mov_name->title,
        );

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        file_get_contents($url, false, $context);

        return json_encode(['status' => true]);

    }


}