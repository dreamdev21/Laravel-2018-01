<?php

namespace App\Http\Controllers;


use App\BannerAdvertising;
use App\Genre;
use App\Hpslide;
use App\Movie;
use App\PostCategory;
use App\Rate;
use App\Videos;
use App\WhatsOnTv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Post;

use Illuminate\Support\Facades\Storage;
use MetaTag;

class StartController extends Controller
{
    public function acceptCookie(Request $request)
    {
        Session::set('cook', 1);
    }

    public static function checkCookie()
    {
        return Session::has('cook');
    }

    public function index(){

        $hpslider = Hpslide::select('img')->get();
        return view('welcome', compact('hpslider'));
    }

    public function policy()
    {

        return view('front/privacy');
    }

    public function partners()
    {

        return view('front/partners');
    }

    public function tos()
    {

        return view('front/tos');
    }

    public function african_TV()
    {
        $covers = [];
        $covers['main'] = WhatsOnTv::where('type','main')->first();
        if(!empty($covers['main']->image)) $covers['main']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['main']->image);
        $covers['small_1'] = WhatsOnTv::where([['type','small'],['number',1]])->first();
        if(!empty($covers['small_1']->image)) $covers['small_1']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['small_1']->image);
        $covers['small_2'] = WhatsOnTv::where([['type','small'],['number',2]])->first();
        if(!empty($covers['small_2']->image)) $covers['small_2']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['small_2']->image);
        $covers['small_3'] = WhatsOnTv::where([['type','small'],['number',3]])->first();
        if(!empty($covers['small_3']->image)) $covers['small_3']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['small_3']->image);
        $covers['small_4'] = WhatsOnTv::where([['type','small'],['number',4]])->first();
        if(!empty($covers['small_4']->image)) $covers['small_4']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['small_4']->image);
        $covers['small_5'] = WhatsOnTv::where([['type','small'],['number',5]])->first();
        if(!empty($covers['small_5']->image)) $covers['small_5']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['small_5']->image);
        $covers['mid_1'] = WhatsOnTv::where([['type','mid'],['number',1]])->first();
        if(!empty($covers['mid_1']->image)) $covers['mid_1']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['mid_1']->image);
        $covers['mid_2'] = WhatsOnTv::where([['type','mid'],['number',2]])->first();
        if(!empty($covers['mid_2']->image)) $covers['mid_2']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['mid_2']->image);
        $covers['mid_3'] = WhatsOnTv::where([['type','mid'],['number',3]])->first();
        if(!empty($covers['mid_3']->image)) $covers['mid_3']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['mid_3']->image);
        $covers['mid_4'] = WhatsOnTv::where([['type','mid'],['number',4]])->first();
        if(!empty($covers['mid_4']->image)) $covers['mid_4']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['mid_4']->image);
        $covers['mid_5'] = WhatsOnTv::where([['type','mid'],['number',5]])->first();
        if(!empty($covers['mid_5']->image)) $covers['mid_5']->image = Storage::disk('s3frenvid')->url('admin/cover/'.$covers['mid_5']->image);
        return view('front/talehouse', compact('covers'));
    }

    public function ads(){

        return view('front/adplacement');
    }

    public function google(){

        return view('front/google3aa71c798a7bf3a8');
    }

    public function sitemap()
    {
        $news = Post::orderBy('created_at', 'desc')->get();
        return response()->view('sitemap', compact('news'))->header('Content-Type', 'text/xml');
    }

    public function movies($slug)
    {

        $news = PostCategory::with('posts')->get();
        $last_news = Post::orderBy('created_at', 'desc')->limit(5)->get();
        $banner_ads_news1 = BannerAdvertising::where('id', 2)->first();
        $vidarr = [];
        $all_vid = Videos::where('slide_public', 1)->get();

        foreach ($all_vid as $vid){
            if (strpos($vid, 'youtube.com') != false) {
                $vidarr[] = $vid;
            }
        }

        $dayname = Carbon::now()->format('l');


        $rate_movie = '';

        $movie = Movie::/*with('genre')->*/with('parental')->where('slug', $slug)->first();
        $genres = Genre::whereIn('id', explode(',',$movie->genre_id))->get();


        $total_rates = Rate::where('movie_id', $movie->id)->get();

        if(count($total_rates) == 0){
            $rate_movie = false;
        }
        else {
            $rate_movie = $total_rates->sum('rate') / $total_rates->count();
        }

        $movies = Movie::limit(15)->inRandomOrder()->where('type', 'movie')->get();

        return view('detailsguest', compact('movie', 'movies', 'genres', 'rate_movie', 'news', 'last_news', 'banner_ads_news1', 'vidarr', 'dayname'));
    }

}
