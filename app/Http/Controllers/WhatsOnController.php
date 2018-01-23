<?php

namespace App\Http\Controllers;

use App\WhatsOnTv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class WhatsOnController extends Controller
{
    public function index(){
        $covers['main'] = WhatsOnTv::where('type','main')->first();
        $covers['small_1'] = WhatsOnTv::where([['type','small'],['number',1]])->first();
        $covers['small_2'] = WhatsOnTv::where([['type','small'],['number',2]])->first();
        $covers['small_3'] = WhatsOnTv::where([['type','small'],['number',3]])->first();
        $covers['small_4'] = WhatsOnTv::where([['type','small'],['number',4]])->first();
        $covers['small_5'] = WhatsOnTv::where([['type','small'],['number',5]])->first();
        $covers['mid_1'] = WhatsOnTv::where([['type','mid'],['number',1]])->first();
        $covers['mid_2'] = WhatsOnTv::where([['type','mid'],['number',2]])->first();
        $covers['mid_3'] = WhatsOnTv::where([['type','mid'],['number',3]])->first();
        $covers['mid_4'] = WhatsOnTv::where([['type','mid'],['number',4]])->first();
        $covers['mid_5'] = WhatsOnTv::where([['type','mid'],['number',5]])->first();
        return view('admin.whatsOnTv.index', compact('covers'));
    }

    public function update(Request $request){
        $main_cover = WhatsOnTv::where('type','main')->first();
        $small_covers = WhatsOnTv::where('type','small')->get();
        $mid_covers = WhatsOnTv::where('type', 'mid')->get();

        $main_cover->title = $request->input('text-lg-1');
        $main_cover->description = $request->input('text-lg-2');
        $main_cover->channel = $request->input('text-lg-3');
        $main_cover->info = $request->input('text-lg-4');
        if($request->hasFile('main-image')){
            $image = $request->file('main-image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save( public_path('assets/images/covers' . $filename));
            $main_cover->image = $filename;
            $s3 = Storage::disk('s3frenvid');
            $s3->put('/admin/cover/'.$filename, file_get_contents(public_path('assets/images/covers' . $filename)), 'public');
            unlink(public_path('assets/images/covers' . $filename));
        }
        $main_cover->save();

        foreach ($small_covers as $cover){
            $num = strval($cover->number);
            $cover->title = $request->input('text-title-sm-'.$num);
            $cover->description = $request->input('text-desc-sm-'.$num);
            if($request->hasFile('small-image-'.$num)){
                $image = $request->file('small-image-'.$num);
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save( public_path('assets/images/covers' . $filename));
                $cover->image = $filename;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/admin/cover/'.$filename, file_get_contents(public_path('assets/images/covers' . $filename)), 'public');
                unlink(public_path('assets/images/covers' . $filename));
            }
            $cover->save();
        }

        foreach ($mid_covers as $cover){
            $num = strval($cover->number);
            $cover->title = $request->input('text-title-md-'.$num);
            $cover->description = $request->input('text-desc-md-'.$num);
            $cover->info = $request->input('text-info-md-'.$num);
            if($request->hasFile('mid-image-'.$num)){
                $image = $request->file('mid-image-'.$num);
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save( public_path('assets/images/covers' . $filename));
                $cover->image = $filename;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/admin/cover/'.$filename, file_get_contents(public_path('assets/images/covers' . $filename)), 'public');
                unlink(public_path('assets/images/covers' . $filename));
            }
            $cover->save();
        }

        return redirect()->back();
    }
}
