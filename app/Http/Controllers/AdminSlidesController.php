<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Slide;
use App\SlideMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;




class AdminSlidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $slides = Slide::all();
        return view('admin.categories.slidesList', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
           'title' => 'required|max:255'
        ));

        $slides = new Slide;

        $slides->title = $request->title;
        $slides->save();

        Session::flash('success', 'A new slide has been added!');
        return redirect()->route('slides.index');
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
        $slides = Slide::all($id);
        $movies = Movie::orderBy('title')->get();

        return View('admin.slides.index', compact('slides', 'movies'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $slides = Slide::find($id);
        $slides->delete();

        Session::flash('message', 'Slide Successfully deleted!');
        return redirect()->route('slides.index');
    }
}
