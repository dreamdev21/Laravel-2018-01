<?php

namespace App\Http\Controllers;

use App\Parental;
use App\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Season;
use App\Genre;
use App\Director;
use App\Studio;
use App\Movie;
use App\Payment;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class AdminSeriesController extends Controller
{

    public function index()
    {
        $series = [];
        $all_pay = [];
        $movies = [];
        if(Auth::user()->role == 1){
            $movie = Movie::where('type', 'serie')->get();
            foreach ($movie as $val) {
                $val['series'] = Serie::where('id', $val->series_id)->select('name')->first();
                $val['season'] = Season::where('id', $val->season_id)->select('number')->first();
                $movies[] = $val;
            }
            $allseries = Serie::get();
            foreach ($allseries as $serie){
                $serie['season'] = Season::where('series_id', $serie->id)->get();
                $series[] = $serie;
            }
        }
        else if(Auth::user()->role == 2){
            $studio = Studio::where('id', Auth::user()->studio_id)->first();
            $movie = Movie::where('type', 'serie')->where('studio_id', Auth::user()->studio_id)->get();
            $allseries = Serie::where('studio_id',Auth::user()->studio_id)->get();

            foreach ($allseries as $serie){
                $serie['season'] = Season::where('series_id', $serie->id)->get();
                $series[] = $serie;
            }

            foreach ($movie as $val){
                $val['series'] = Serie::where('id', $val->series_id)->select('name')->first();
                $val['season'] = Season::where('id', $val->season_id)->select('number')->first();
                $movies[] = $val;

                $calcpay_serie = Payment::where('series_id', $val->series_id)->get();
                $calcpay_season = Payment::where('season_id', $val->season_id)->get();
                $calcpay_episode = Payment::where('movie_id', $val->id)->get();

                $all_pay['serid_'.$val->series_id] = $calcpay_serie->sum('amount') / 100 * $studio->percent;
                $all_pay['seasid_'.$val->season_id] = $calcpay_season->sum('amount') / 100 * $studio->percent;
                $all_pay['mid_'.$val->id] = $calcpay_episode->sum('amount') / 100 * $studio->percent;

                $all_pay['series_total_'.$val->series_id] = ($calcpay_serie->sum('amount') + $calcpay_season->sum('amount') + $calcpay_episode->sum('amount')) / 100 * $studio->percent;
                $all_pay['season_total_'.$val->season_id] = ($calcpay_season->sum('amount') + $calcpay_episode->sum('amount')) / 100 * $studio->percent;
            }

        }

        $parental = Parental::get();

        return view('admin.series.index', compact('series', 'movies', 'all_pay', 'parental'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        $studios = Studio::get();
        return view('admin.series.create', compact('studios', 'genres'));
    }

    public function create_season()
    {
        if(Auth::user()->role == 1){
            $series = Serie::get();
        }
        else{
            $series = Serie::where('studio_id', Auth::user()->studio_id)->get();
        }
        return view('admin.series.create_season', compact('series'));
    }

    public function create_episode()
    {

        if(Auth::user()->role == 1){
            $genres = Genre::all();
            $directors = Director::all();
            if(Auth::user()->role == 2){
                $studios = Studio::where('id', Auth::user()->studio_id)->get();
            }
            else{
                $studios = Studio::all();
            }
            $directories = Storage::disk('s3frenvid');
            $all_files_aws_res_films = $directories->allFiles('/uploads/eachstudio/films/');
            $aws_all_mov_url = array();
            $aws_all_trailer_url = array();
            foreach ($all_files_aws_res_films as $all_files_aws){
                $aws_all_mov_url[] = $directories->url($all_files_aws);
            }

            $all_files_aws_res_trailers = $directories->allFiles('/uploads/eachstudio/trailer/');
            foreach ($all_files_aws_res_trailers as $all_files_aws_t){
                $aws_all_trailer_url[] = $directories->url($all_files_aws_t);
            }

            $series = Serie::get();

            return view('admin.series.create_episode', compact(['studios', 'directors', 'genres', 'aws_all_mov_url', 'aws_all_trailer_url', 'series']));
        }
        else{
            $directories = Storage::disk('s3frenvid');

            if(Auth::user()->role == 2){
                $studios = Studio::where('id', Auth::user()->studio_id)->get();


                $genres = Genre::all();
                $directors = Director::all();
                if(Auth::user()->role == 2){
                    $studios_all = Studio::where('id', Auth::user()->studio_id)->get();
                }
                else{
                    $studios_all = Studio::all();
                }

                $series = Serie::where('studio_id', Auth::user()->studio_id)->get();

                return view('admin.series.createprod_episode', compact('studios', 'studios_all', 'directors', 'genres', 'series'));
            }
        }

    }

    public function store_season(Request $request)
    {
        $this->validate($request, array(
            'series_id' => 'int:required',
            'number' => 'int:required',
            'price' => 'required|numeric|min:0.1',
            'period' => 'required|integer|min:1',
        ));
        $season = new Season;
        $season->series_id = $request->series_id;
        $season->number = $request->season_number;
        $season->price = $request->price;
        $season->period = $request->period;
        $season->save();
        Session::flash('success', 'The seasone was successfully added!');
        return redirect()->route('series.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request);
        $this->validate($request, array(
            'series_name' => 'required|max:255',
            'poster' => 'required|image',
            'description' => 'required',
            'price' => 'required|numeric|min:0.1',
            'period' => 'required|integer|min:1',
            'genre_id' => 'required',
        ));


        $series = new Serie;
        if(Auth::user()->role == 1){
            $series->studio_id = $request->studio_id;
        }
        else{
            $series->studio_id = Auth::user()->studio_id;
        }
        if($request->hasFile('poster')){
            $image = $request->file('poster');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(250, 383)->save($location);

            $oldFilename = $series->poster;

            $series->poster = $filename;

            Storage::delete($oldFilename);
        }
        $series->name = $request->series_name;
        $series->description = $request->description;
        $series->price = $request->price;
        $series->period = $request->period;
        $series->actors = $request->actor;
        $series->genre_id = $request->genre_id;
        $series->save();

        Session::flash('success', 'The series was successfully added!');

        return redirect()->route('series.index');

    }


    public function get_seasons(Request $request)
    {
        $res = Season::where('series_id', $request->serie_id)->get();
        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $movie = Movie::find($id);
//        return view('admin.movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        //find the movie in the database and save as a variable
//        $movie = Movie::find($id);
//        if(Auth::user()->id != 1){
//            if($movie->studio_id != Auth::user()->studio_id){
//                return redirect()->back();
//            }
//        }
//
//
//        $directories = Storage::disk('s3frenvid');
//        $all_files_aws_res_films = $directories->allFiles('/uploads/eachstudio/films/');
//        $aws_all_mov_url = array();
//        $aws_all_trailer_url = array();
//        foreach ($all_files_aws_res_films as $all_files_aws){
//            $aws_all_mov_url[] = $directories->url($all_files_aws);
//        }
//
//        $all_files_aws_res_trailers = $directories->allFiles('/uploads/eachstudio/trailer/');
//        foreach ($all_files_aws_res_trailers as $all_files_aws_t){
//            $aws_all_trailer_url[] = $directories->url($all_files_aws_t);
//        }
//
//        return view('admin.movies.edit', compact('movie', 'aws_all_mov_url', 'aws_all_trailer_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validate($request, array(
//            'title' => 'required|max:255',
//            'year' => 'required|integer',
//            'description' => 'required',
//            'poster' => 'required|image',
//            'url' => 'required',
//            'price' => 'required|numeric|min:0.1',
//            'period' => 'required|integer|min:1'
//        ));
//
//        //get movie in database by id
//
//        $movie = Movie::find($id);
//
//        $movie->title = $request->input('title');
//        $movie->year = $request->input('year');
//        $movie->description = Purifier::clean($request->input('description'));
//        $movie->url = $request->input('url');
//        $movie->price = $request->input('price');
//        $movie->period = $request->input('period');
//
//
//
//        if($request->hasFile('poster')){
//            $image = $request->file('poster');
//            $filename = time() . '.' . $image->getClientOriginalExtension();
//            $location = public_path('assets/images/' . $filename);
//            Image::make($image)->resize(150, 230)->save($location);
//
//            $oldFilename = $movie->poster;
//
//            $movie->poster = $filename;
//
//            Storage::delete($oldFilename);
//        }
//
//        $movie->save();
//
//        Session::flash('success', 'The movie was successfully added!');
//
//        return redirect()->route('movies.index', $movie->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $movie = Movie::find($id);
//        Storage::delete($movie->poster);
//        $movie->delete();
//
//        // redirect
//        Session::flash('message', 'Movie Successfully deleted!');
//        return redirect()->route('movies.index');
    }

    public function makeEpisodePublic(Request $request)
    {
        $mid = $request->id;
        $movie  = Movie::where('id', $mid)->first();
        if($movie->publish == 0){
            $movie->publish = 1;
        }
        else{
            $movie->publish = 0;
        }
        $movie->save();
    }

}
