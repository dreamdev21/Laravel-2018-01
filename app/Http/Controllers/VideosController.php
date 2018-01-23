<?php

namespace App\Http\Controllers;

use App\Movie;
use App\MovieGenre;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public function index()
    {

        return view('movies');
    }

    public function movie()
    {
        return view('movie');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
