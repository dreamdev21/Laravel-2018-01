<?php

namespace App\Http\Controllers;

use App\Director;
use App\Episode;
use App\Follow;
use App\Genre;
use App\Coplay;
use App\GenreMovie;
use App\Season;
use Illuminate\Http\Request;
use App\Movie;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Watchlist;
use App\Payment;
use Carbon\Carbon;
use App\Serie;
use App\Rate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class MoviesController extends Controller
{

    private $movies;

    public function __construct(Movie $movies)
    {
        $this->middleware('auth');
        $this->middleware('paid');
        $this->movies = $movies;
    }

    public static function getRandMovie()
    {
        $my_ip = file_get_contents('https://freegeoip.net/json/');
        $timezone_by_ip = json_decode($my_ip,true);
        $continent = explode("/",$timezone_by_ip['time_zone']);
        $continent = $continent[0];
        $movies = Movie::select('poster','title','slug','description')->where('blacklist','not % like %',$continent)->orWhere('blacklist', '=',NULL)->where('type','=','movie')->where('publish',1)->inRandomOrder()->limit(2)->get();

        return $movies;
    }

    public function index()
    {
        $my_ip = file_get_contents('https://freegeoip.net/json/');
        $timezone_by_ip = json_decode($my_ip,true);
        $continent = explode("/",$timezone_by_ip['time_zone']);
        $continent = $continent[0];

//        in_array($continent, explode(',', $movi->blacklist))

        $movie_ser = Serie::get();
        $genres = Genre::get();
        $movies = Movie::orderBy('created_at', 'DESC')->where('blacklist','not % like %',$continent)->orWhere('blacklist', '=',NULL)->where('publish',1)->get();

        $ganre_list = [];
        $gan_mov    = [];

        foreach ($genres as $genre){
            foreach ($movies as $movie){
                $gids = $movie->genre_id;
                $gids = explode(',',$gids);

                foreach ($gids as $gid){

                    if( $genre->id == $gid){
                        $mov_qaq = Movie::where('id', $movie->id)->first();
                        $gan_mov[] = $mov_qaq;
                    }

                }
            }
            $gmarr['genre'] = $genre;
            $gmarr['movies'] = $gan_mov;
            $ganre_list[] = $gmarr;
            $gan_mov = [];
        }

        return view('movies', compact('ganre_list', 'episodes', 'movie_ser'));
    }

    public function get_trailer(Request $request)
    {
        return Movie::select('trailer')->where('id', $request->movie_id)->first();
    }

    public function show_series()
    {
        $genres = Genre::get();
        $series = Serie::orderBy('created_at', 'DESC')->get();

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

        return view('tvseries', compact('ganre_list'));
    }

    public function details($slug)
    {
        $movies = Movie::with('parental')->where('slug', '=', $slug)->where('type', 'movie')->first();
        $wlist = Watchlist::where('user_id', Auth::id())->get();
        $mov_genre  = Movie::select('genre_id')->where('slug',$slug)->first();
        $genres = Genre::whereIn('id', explode(',',$mov_genre->genre_id))->get();
        $wlist_res = false;
        if(isset($wlist)){
            foreach ($wlist as $wl){
                if($wl->movie_id == $movies->id){
                    $wlist_res = true;
                }
            }
        }

        $duration[] =explode(':',$movies->duration);
        $duration = $duration[0][0].'h'.$duration[0][1].'m';
        $movies->duration = $duration;

        $rent = Payment::where('user_id', Auth::id())->where('movie_id', $movies->id)->orderBy('id', 'desc')->first();

        $coplay_inv_count_res = false;

        if($rent){
            $coplay_inv_count_res = Coplay::where('payment_id', $rent->id)->where('inv_from', Auth::user()->id)->where('inv_mov_id', $movies->id)->count();

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
            $rate_user  = Rate::where('user_id', Auth::user()->id)->first();
        }
        if($rate_user == null){
            $rate_user = false;
        }
        if($rate_movie == null){
            $rate_movie = false;
        }

        $us_fr_s = [];


        $all_fol_users = [];
        $fol_users = Follow::where('user_id', Auth::id())->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', Auth::id())->first();

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

        return view('movie', compact('movies', 'wlist_res', 'genres', 'reswl', 'rental', 'rental_id', 'coplay_inv_count_res', 'rate_movie', 'rate_user', 'us_fr_s'));
    }

    public function details_series($slug)
    {
        $series = Serie::where('slug', '=', $slug)->first();
        $series->genre;
        $rent = Payment::where('user_id', Auth::id())->where('series_id', $series->id)->orderBy('id', 'desc')->first();

        $mov_genre  = Serie::select('genre_id')->where('slug',$slug)->first();
        $genres = Genre::whereIn('id', explode(',',$mov_genre->genre_id))->get();

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

        return view('series', compact('series', 'rental', 'genres', 'season_res'));
    }

    public function details_season($slug, $season_id)
    {

        $series = Serie::where('slug', '=', $slug)->first();
        $series->genre;

        $season = Season::where('series_id', $series->id)->where('id', $season_id)->first();

        $season['episodes'] = Movie::where('series_id', $series->id)->where('season_id', $season->id)->where('publish',1)->get();

        $rent = Payment::where('user_id', Auth::id())->where('season_id', $season->id)->orderBy('id', 'desc')->first();

        $mov_genre  = Serie::select('genre_id')->where('slug',$slug)->first();
        $genres = Genre::whereIn('id', explode(',',$mov_genre->genre_id))->get();

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
            $rent_series = Payment::where('user_id', Auth::id())->where('series_id', $series->id)->orderBy('id', 'desc')->first();
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

        return view('season', compact('series', 'rental', 'genres', 'season'));
    }

    public function details_episode($slug)
    {
        $episode = Movie::where('slug', '=', $slug)->where('type', 'serie')->first();

        $wlist = Watchlist::where('user_id', Auth::id())->get();

        //$mov_genre  = Serie::select('genre_id')->where('slug',$slug)->first();
        //dd($episode);
        $genres = Genre::whereIn('id', explode(',',$episode->genre_id))->get();
//        $director = Director::where('id',$episode->director_id)->first();
//        $director = $director->name;
//        $episode->director_id = $director;

        $wlist_res = false;
        if(isset($wlist)){
            foreach ($wlist as $wl){
                if($wl->movie_id == $episode->id){
                    $wlist_res = true;
                }
            }
        }
        $duration[] =explode(':',$episode->duration);
        $duration = $duration[0][0].'h'.$duration[0][1].'m';
        $episode->duration = $duration;

        $rent = Payment::where('user_id', Auth::id())->where('movie_id', $episode->id)->orderBy('id', 'desc')->first();

        $coplay_inv_count_res = false;

        if($rent){

            $coplay_inv_count_res = Coplay::where('payment_id', $rent->id)->where('inv_from', Auth::user()->id)->where('inv_mov_id', $episode->id)->count();

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
            $rent_season = Payment::where('user_id', Auth::id())->where('season_id', $episode->season_id)->orderBy('id', 'desc')->first();
            $seasone = Season::where('id', $episode->season_id)->first();
            if($rent_season){

                $coplay_inv_count_res = Coplay::where('payment_id', $rent_season->id)->where('inv_from', Auth::user()->id)->where('inv_mov_id', $episode->id)->count();

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
                $rent_series = Payment::where('user_id', Auth::id())->where('series_id', $episode->series_id)->orderBy('id', 'desc')->first();
                $series = Serie::where('id', $episode->series_id)->first();
                if($rent_series){

                    $coplay_inv_count_res = Coplay::where('payment_id', $rent_series->id)->where('inv_from', Auth::user()->id)->where('inv_mov_id', $episode->id)->count();

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
            $rate_user  = Rate::where('user_id', Auth::user()->id)->first();
        }
        if($rate_user == null){
            $rate_user = false;
        }
        if($rate_movie == null){
            $rate_movie = false;
        }

        $us_fr_s = [];


        $all_fol_users = [];
        $fol_users = Follow::where('user_id', Auth::id())->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', Auth::id())->first();

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

        return view('episode', compact('episode', 'wlist_res', 'reswl', 'rental','genres', 'rental_id', 'coplay_inv_count_res', 'rate_movie', 'rate_user', 'us_fr_s'));
    }

    public function coplay()
    {

        $dt = Carbon::now();

        $curr_time = $dt->toDateTimeString();

        $coplay_res = Coplay::where('inv_to', Auth::id())->where('exp_date', '>', $curr_time)->get();

        $colay_inv = array();

        foreach ($coplay_res as $val){
            $colay_inv['users'][] = User::where('id', $val->inv_from)->first();
            $colay_inv['movies'][] = Movie::where('id', $val->inv_mov_id)->first();
        }


    }

    public function soloPlay($url, Movie $movie)
    {

        if (Auth::guest()){

            if(!$movie->isRentedBy(Auth::user())){
                return Redirect::to('movie',$url);
            }

            return Redirect::to('home');

        }else{

            $movie = Movie::where('url', $url)->get();
        }

        return view('play.soloplay', compact('movie'));
    }

    public function conWl(Request $request)
    {

        $watchlist = new Watchlist;
        $wlControl = Watchlist::where('user_id', Auth::id())->where('movie_id', $request->mid)->first();

        if($wlControl){
            $wlControl->delete();
            echo "del";
            exit;
        }

        $watchlist->user_id = Auth::id();
        $watchlist->movie_id = $request->mid;
        $watchlist->save();
        echo 'ins';
        exit;

    }

    public function delWl(Request $request)
    {
        $wldel = Watchlist::where('user_id', Auth::id())->where('movie_id', $request->del_mid)->first();
        $wldel_res = $wldel->delete();
        echo $wldel_res;
        exit;
    }

    public function play($slug)
    {
        $hide_ads = true;
        $movie = Movie::where('slug', $slug)->first();

        function encryptIt($uid, $mid, $pid) {
            return $uid.'__ROOM__'.$mid.'_P'.$pid;
        }

        if($movie->type == 'serie'){
            //SERIES
            $rent = Payment::where('user_id', Auth::id())->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();

            if($rent){

                $dt = Carbon::now();

                $curr_time     = $dt->toDateTimeString();

                $period        = $movie->period * 60;

                $endTime       = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

                $endTime       = date("Y-m-d H:i:s", $endTime);

                $rental        = $curr_time < $endTime;

                $room_id = encryptIt(Auth::id(), $movie->id, $rent->id);

            }
            else{
                $rental = false;
                $rent_season = Payment::where('user_id', Auth::id())->where('season_id', $movie->season_id)->orderBy('id', 'desc')->first();
                $seasone = Season::where('id', $movie->season_id)->first();
                if($rent_season){
                    $dt = Carbon::now();

                    $curr_time     = $dt->toDateTimeString();

                    $period        = $seasone->period * 60;

                    $endTime       = strtotime('+'.$period.' minutes', strtotime($rent_season->created_at->toDateTimeString()));

                    $endTime       = date("Y-m-d H:i:s", $endTime);

                    $rental        = $curr_time < $endTime;

                    $room_id = encryptIt(Auth::id(), $movie->id, $rent_season->id);
                }
                else{
                    $rental = false;
                    $rent_series = Payment::where('user_id', Auth::id())->where('series_id', $movie->series_id)->orderBy('id', 'desc')->first();
                    $series = Serie::where('id', $movie->series_id)->first();
                    if($rent_series){
                        $dt = Carbon::now();

                        $curr_time     = $dt->toDateTimeString();

                        $period        = $series->period * 60;

                        $endTime       = strtotime('+'.$period.' minutes', strtotime($rent_series->created_at->toDateTimeString()));

                        $endTime       = date("Y-m-d H:i:s", $endTime);

                        $rental        = $curr_time < $endTime;

                        $room_id = encryptIt(Auth::id(), $movie->id, $rent_series->id);
                    }
                    else{
                        $rental = false;
                    }
                }
            }

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $coplay_res = Coplay::where('inv_to', Auth::id())->where('inv_mov_id', $movie->id)->where('usm', 0)->where('exp_date', '>', $curr_time)->first();
            $coplay = $coplay_res;
            if($coplay_res){
                $room_id = encryptIt($coplay_res->inv_from, $movie->id, $coplay_res->payment_id);

            }

            if(!$rental && !$coplay){
                return Redirect()->back();
            }




            return view('mplay', compact('movie', 'room_id', 'rental', 'hide_ads'));
        }
        else{

            $rent = Payment::where('user_id', Auth::id())->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();


            if($rent){

                $dt = Carbon::now();

                $curr_time     = $dt->toDateTimeString();

                $period        = $movie->period * 60;

                $endTime       = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

                $endTime       = date("Y-m-d H:i:s", $endTime);

                $rental        = $curr_time < $endTime;

                $room_id = encryptIt(Auth::id(), $movie->id, $rent->id);

            }
            else{
                $rental = false;

            }

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $coplay_res = Coplay::where('inv_to', Auth::id())->where('inv_mov_id', $movie->id)->where('usm', 0)->where('exp_date', '>', $curr_time)->first();
            $coplay = $coplay_res;
            if($coplay_res){
                $room_id = encryptIt($coplay_res->inv_from, $movie->id, $coplay_res->payment_id);

            }

            if(!$rental && !$coplay){
                return Redirect()->back();
            }


            return view('mplay', compact('movie', 'room_id', 'rental', 'hide_ads'));
        }


    }

    public function soplay($slug)
    {
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

        $rent = Payment::where('user_id', Auth::id())->where('movie_id', $movie->id)->orderBy('id', 'desc')->first();

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

            $rent_season = Payment::where('user_id', Auth::id())->where('season_id', $movie->season_id)->orderBy('id', 'desc')->first();
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

                $rent_series = Payment::where('user_id', Auth::id())->where('series_id', $movie->series_id)->orderBy('id', 'desc')->first();
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
            return redirect()->back();
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

        return view('soplay', compact('movie', 'rental', 'vtoken', 'url', 'hide_ads'));


    }

    public function getAwsVideo($id, $token){

        if(Session::has('vtoken') != null){
            if(Session::get('vtoken') == $token){
                $mv = Movie::select('url')->where('id', $id)->first();
                Session::forget('vtoken');
                return redirect($mv->url);
            }
            else{
                echo '<h3 style="color: red;">Access denied<h3>';
            }
        }
        else{
            echo '<h3 style="color: red;">Access denied<h3>';
        }

    }

    public function delCoplay(Request $request)
    {
        $mov_id_by_slug     = Movie::where('slug', $request->movslug)->first();
        $coplay_res         = Coplay::where('inv_to', Auth::id())->where('inv_mov_id', $mov_id_by_slug->id)->update(['usm' => 1]);
        echo $coplay_res;
        exit;
    }

    public function coplayInv(Request $request)
    {
        $user_id                  = $request->u_id;
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
                echo 4001;
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
                    echo $coplay_inv_count_res;
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
                'cp_u_from' => Auth::id(),
                'cp_u_avatar' => Auth::user()->avatar,
                'cp_u_to' => $all_f,
                'cp_u_to_username' => $all_f_username,
                'cp_u_username' => Auth::user()->username,
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




            echo 4 - ++$coplay_inv_count_res;
            exit;
        }
        else{


            $rent = Payment::where('id', $payment_id)->orderBy('id', 'desc')->first();

            $coplay_inv_res = Coplay::where('payment_id', $payment_id)->where('inv_from', $user_id)->where('inv_mov_id', $movie_id)->count();

            if($coplay_inv_res != 0){
                echo 4001;
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
                    echo $coplay_inv_count_res;
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
                'cp_u_from' => Auth::id(),
                'cp_u_avatar' => Auth::user()->avatar,
                'cp_u_to' => $all_f,
                'cp_u_to_username' => $all_f_username,
                'cp_u_username' => Auth::user()->username,
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


            echo 4 - ++$coplay_inv_count_res;
            exit;


        }

    }

    public function setRate(Request $request)
    {
        $mid = $request->mid;
        $val = $request->value;

        $rate = new Rate;
        $rate->user_id    = Auth::user()->id;
        $rate->movie_id   = $mid;
        $rate->rate       = $val;
        $rate->save();
    }

}
















