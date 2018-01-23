<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Genre;
use App\Movie;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use File;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;
use Intervention\Image\Facades\Image;




class AdminEpisodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $episode = Episode::orderBy('created_at', 'DESC')->paginate(9);
        return view('admin.episode.index', compact('episode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Episode $episode)
    {

        $movies = Movie::where('type', 'serie')->get();
        return view('admin.episode.create', compact('movies', 'episode'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd(123123);

        $this->validate($request, array(
            'movie_id' => 'required',
            'episode_name' => 'required',
            'episode_number' => 'required',
            'episode_description' => 'required',
            'season_number' => 'required',
            'episode_thumbnail' => 'required',
            'episode_source' => 'required',


        ));

        $episode = new Episode;

        $episode->episode_name = $request->episode_name;
        $episode->episode_number = $request->episode_number;
        $episode->episode_description = Purifier::clean($request->episode_description);
        $episode->episode_source = $request->episode_source;
        $episode->episode_price = $request->episode_price;
        $episode->episode_period = $request->episode_period;
        $episode->season_number = $request->season_number;
        $episode->movie_id = $request->movie_id;


        if($request->hasFile('episode_thumbnail')){
            $image = $request->file('episode_thumbnail');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(400, 280)->save($location);

            $oldFilename = $episode->episode_thumbnail;

            $episode->episode_thumbnail = $filename;

            Storage::delete($oldFilename);
        }



        $episode->save();

        Session::flash('success', 'The new Episode was successfully added!');

        return redirect()->route('episodes.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $episode = Episode::find($id);
        return view('admin.episode.edit', compact('episode', 'movies'));
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
        $this->validate($request, array(
            'movie_id' => 'required',
            'episode_name' => 'required',
            'episode_number' => 'required',
            'episode_description' => 'required',
            'season_number' => 'required',
            'episode_thumbnail' => 'required',
            'episode_source' => 'required',


        ));

        $episode = Episode::find($id);

        $episode->episode_name = $request->input('episode_name');
        $episode->episode_number = $request->input('episode_number');
        $episode->episode_description = Purifier::clean($request->input('episode_description'));
        $episode->episode_source = $request->input('episode_source');
        $episode->episode_price = $request->input('episode_price');
        $episode->episode_period = $request->input('episode_period');
        $episode->season_number = $request->input('season_number');
        $episode->movie_id = $request->input('movie_id');


        if($request->hasFile('episode_thumbnail')){
            $image = $request->file('episode_thumbnail');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(400, 280)->save($location);

            $oldFilename = $episode->episode_thumbnail;

            $episode->episode_thumbnail = $filename;

            Storage::delete($oldFilename);
        }



        $episode->save();

        Session::flash('success', 'The new Episode was successfully updated!');

        return redirect()->route('episodes.index', $episode->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::find($id);
        Storage::delete($episode->poster);
        $episode->delete();

        // redirect
        Session::flash('message', 'Episode Successfully deleted!');
        return redirect()->route('episodes.index');
    }
}
