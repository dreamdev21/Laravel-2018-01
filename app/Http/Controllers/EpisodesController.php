<?php

namespace App\Http\Controllers;

use App\Genre;
use App\GenreMovie;
use Illuminate\Http\Request;
use App\Movie;
use App\Episode;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Watchlist;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;


class EpisodesController extends Controller
{

    private $movies;

    public function __construct(Movie $movies)
    {
        $this->middleware('auth');
        $this->middleware('paid');
        $this->movies = $movies;

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {


        $genres = Genre::with(['movies'])->get();
        return view('shows', compact('genres'));
    }


    public function details($slug)
    {
        $movies = Movie::with('parental')->where('slug', '=', $slug)->get();
        $wlist = Watchlist::where('user_id', Auth::id())->get();


        $wlist_res = false;
        if(isset($wlist)){
            foreach ($wlist as $wl){
                if($wl->movie_id == $movies[0]->id){
                    $wlist_res = true;
                }
            }
        }

        $rent = Payment::where('user_id', Auth::id())->where('movie_id', $movies[0]->id)->orderBy('id', 'desc')->first();
        if($rent){

            $dt = Carbon::now();

            $curr_time = $dt->toDateTimeString();

            $period = $movies[0]->period * 60;

            $endTime = strtotime('+'.$period.' minutes', strtotime($rent->created_at->toDateTimeString()));

            $endTime = date("Y-m-d H:i:s", $endTime);

            $rental = $curr_time < $endTime;
        }
        else{
            $rental = false;
        }


        return view('movie', compact('movies', 'wlist_res', 'rental'));
    }

    public function coplay(){

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

        $movie = Movie::where('slug', $slug)->first();
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
        }

        if(!$rental){
            return Redirect::to('/movies/'.$slug);
        }

        return view('mplay', compact('movie'));
    }



    public function inWatchlist(){


    }

}
