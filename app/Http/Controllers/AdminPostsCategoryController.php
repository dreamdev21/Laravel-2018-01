<?php

namespace App\Http\Controllers;

use App\PostCategory;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use App\Post;

class AdminPostsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = PostCategory::all();
        return view('admin.categories.postscategory', compact('categories') );
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
            'name' => 'required|max:255'
        ));

        $postCategories = new PostCategory;

        $postCategories->name = $request->name;
        $postCategories->save();

        Session::flash('success', 'A new Post Category has been created');

        return redirect()->route('postscategory.index');
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
        //
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
        //
    }

    public function delete_post_cat(Request $request)
    {
        $catid = $request->catid;
        Post::where('category_id', $catid)->delete();
        PostCategory::where('id', $catid)->delete();
    }

    public function edit_post_cat(Request $request)
    {
        $catid = $request->catid;
        $cat_name = $request->cat_name;
        $postcat = PostCategory::where('id', $catid)->first();
        $postcat->name = $cat_name;
        $postcat->save();
    }
}
