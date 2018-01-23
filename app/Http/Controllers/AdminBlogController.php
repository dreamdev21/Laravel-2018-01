<?php

namespace App\Http\Controllers;

use App\Hpslide;
use App\Movie;
use Illuminate\Http\Request;
use App\Post;
use App\PostCategory;
use App\Videos;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests;


class AdminBlogController extends Controller
{

    public function index()
    {
        $vidarr = [];
        $all_vid = Videos::get();

        foreach ($all_vid as $vid){
            if (strpos($vid, 'youtube.com') != false) {
                $vidarr[] = $vid;
            }
        }

        $posts = Post::orderBy('id', 'desc')->paginate(8);
        return view('admin.posts.index', compact('posts', 'vidarr'));
    }


    public function movieslide()
    {
        $movies = Movie::orderBy('id', 'desc')->where('type', 'movie')->get();
        return view('admin.posts.movieslide', compact('movies'));
    }


    public function create()
    {
       $postCategories = PostCategory::all();
        return view('admin.posts.create', compact('postCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'title'             => 'required|max:255',
            'body'              => 'required',
            'category_id'       => 'required|integer',
            'image'             => 'sometimes|image'
        ));


        //store in database
        $post = new Post;

        $post->title              = $request->title;
        $post->category_id        = $request->category_id;
        $post->body               = Purifier::clean($request->body);
        $post->video              = $request->video;
        $post->tags               = json_encode(explode(',', $request->tags));

        $slug = $request->title;

//        if( strlen( $slug ) > 30 ) {
//            $slug = substr($slug, 0, 30);
//        }
        $post->slug = str_slug($slug);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(800, 500)->save($location);

            $post->image = $filename;
        };

        $post->save();

        Session::flash('success', 'The new post was successfully added!');

        //redirect
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the post in the database and save as a variable
        $post = Post::find($id);
        $post->tags = json_decode($post->tags);
        return view('admin.posts.edit', compact('post'));
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
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'image'
        ));

        //store in database

        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->body  = Purifier::clean($request->input('body'));
        $post->tags  = json_encode(explode(',', $request->tags));


        if($request->hasFile('image')){
            //add the new photo
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(800, 500)->save($location);

            $oldFilename = $post->image;

            //update the database
            $post->image = $filename;

            Storage::delete($oldFilename);
        }

        $post->save();

        Session::flash('success', 'Your change was successfully added!');

        //redirect

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        Storage::delete($post->image);
        $post->delete();

        // redirect
        Session::flash('message', 'Post Successfully deleted!');
        return redirect()->route('posts.index');
    }


    public function hpSlideShow()
    {
        $hpslider = Hpslide::get();
        return view('admin.hp_slide', compact('hpslider'));
    }

    public function addHpSlideImage(Request $request)
    {
        $this->validate($request, array(
            'img' => 'required|image'
        ));

        //store in database

        if($request->hasFile('img')){
            $hpslider = new Hpslide;
            $image = $request->file('img');
            $filename = time() . '_hp_slide.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->save($location);
            $hpslider->img = $filename;
            $hpslider->save();
        }

        return redirect()->back();
    }

    public function delHpSlideImage(Request $request){
        $id = $request->img_id;
        $hpslider = Hpslide::where('id', $id)->first();
        unlink(public_path('assets/images/'.$hpslider->img));
        $hpslider->delete();
    }


}
