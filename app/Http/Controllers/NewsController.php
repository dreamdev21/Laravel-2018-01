<?php

namespace App\Http\Controllers;

use App\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;
use App\PostCategory;
use App\BannerAdvertising;
use App\Videos;

use MetaTag;


class NewsController extends Controller
{

    public function index()
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

        $movies = Movie::orderby('created_at', 'DESC')->where('type', 'movie')->where('slide_public', 1)->get();

        return view('news', compact('news', 'movies', 'last_news', 'banner_ads_news1', 'vidarr', 'dayname') );
    }

    public function getSinglePost($slug)
    {
        $article = Post::with('postCategory')->where('slug', '=', $slug)->first();
        if(!$article) return redirect('/news');
        $last_news = Post::orderBy('id', 'DESC')->limit(5)->get();
        $banner_ads_news1 = BannerAdvertising::where('id', 2)->first();
        $cat_all_posts = Post::where('category_id', $article->category_id)->where('id', '!=', $article->id)->limit(5)->get();
        $rand_posts = Post::where('category_id', $article->category_id)->where('id', '!=', $article->id)->inRandomOrder()->limit(2)->get();
        $vidarr = [];
        $all_vid = Videos::where('slide_public', 1)->get();

        foreach ($all_vid as $vid){
            if (strpos($vid, 'youtube.com') != false) {
                $vidarr[] = $vid;
            }
        }

        $dayname = Carbon::now()->format('l');
        if($article->tags){
            $article->tags = json_decode($article->tags);
        }

        return view('singlenews', compact('article', 'banner_ads_news1', 'cat_all_posts', 'rand_posts', 'last_news', 'vidarr', 'dayname'));
    }

    public function getNews(Request $request)
    {
        $cat_id    = $request->cat_id;
        $cat_count = $request->cat_count;
        $news_res = Post::orderBy('updated_at', 'DESC')->where('category_id', $cat_id)->skip($cat_count)->take(4)->get();
        echo json_encode($news_res);
        exit;
    }

    public function searchNews(Request $request)
    {
        $search_words = $request->search_words;
        $search_res = Post::where('title', 'LIKE', '%'.$search_words.'%')->take(6)->get();
        return response()->json($search_res);
    }

}
