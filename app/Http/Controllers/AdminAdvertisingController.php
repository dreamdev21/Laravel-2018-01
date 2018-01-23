<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Advertising;
use App\Videos;
use App\Channel;
use JmesPath\Env;
use Session;
use File;
use App\BannerAdvertising;

class AdminAdvertisingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner_ads = BannerAdvertising::where('id', 1)->first();
        $banner_ads_news1 = BannerAdvertising::where('id', 2)->first();
        $banner_ads_left = BannerAdvertising::where('id', 3)->first();
        $banner_ads_left2 = BannerAdvertising::where('id', 4)->first();
        $banner_ads_left3 = BannerAdvertising::where('id', 16)->first();
        $banner_ads_right = BannerAdvertising::where('id', 5)->first();
        $banner_ads_right1_2 = BannerAdvertising::where('id', 8)->first();
        $banner_ads_right1_3 = BannerAdvertising::where('id', 9)->first();
        $banner_ads_right2 = BannerAdvertising::where('id', 6)->first();
        $banner_ads_right2_2 = BannerAdvertising::where('id', 10)->first();
        $banner_ads_right2_3 = BannerAdvertising::where('id', 11)->first();
        $banner_ads_right3 = BannerAdvertising::where('id', 7)->first();
        $banner_ads_right3_2 = BannerAdvertising::where('id', 12)->first();
        $banner_ads_right3_3 = BannerAdvertising::where('id', 13)->first();
        $banner_ads_left1_2 = BannerAdvertising::where('id', 14)->first();
        $banner_ads_left2_2 = BannerAdvertising::where('id', 15)->first();
        $banner_ads_left3_2 = BannerAdvertising::where('id', 17)->first();

        $ads = Advertising::get();
        return view('admin.advertising.index', compact('ads', 'banner_ads', 'banner_ads_news1', 'banner_ads_left', 'banner_ads_left1_2', 'banner_ads_left2', 'banner_ads_left2_2', 'banner_ads_left3', 'banner_ads_left3_2', 'banner_ads_right', 'banner_ads_right1_2', 'banner_ads_right1_3', 'banner_ads_right2', 'banner_ads_right2_2', 'banner_ads_right2_3', 'banner_ads_right3', 'banner_ads_right3_2', 'banner_ads_right3_3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advertising.create');
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
            'preroll_name' => 'required',
            'preroll_type' => 'required',
            'preroll_goto_link' => 'required',
            'preroll_skip_timer' => 'required',
            'preroll_mp4' => 'required',
            'thumb_img' => 'required'
        ));

        $advertising = new Advertising;

        $advertising->preroll_name = $request->preroll_name;
        $advertising->preroll_type = $request->preroll_type;

        $advertising->preroll_goto_link = $request->preroll_goto_link;
        $advertising->preroll_skip_timer = $request->preroll_skip_timer;
        $advertising->preroll_mp4 = '';
        $advertising->preroll_thumbimg = '';

        if($request->preroll_mp4 != null){
            if($request->preroll_mp4->getClientOriginalExtension() == 'mp4'){
                $file = uniqid().'v.'.$request->preroll_mp4->getClientOriginalExtension();
                $request->preroll_mp4->move(public_path('ad_up/videos'), $file);
                $video = public_path('ad_up/videos/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/videos/'.$file, file_get_contents($video), 'public');
                unlink($video);
                $advertising->preroll_mp4 = $file;
            }
        }

        if($request->thumb_img != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->thumb_img->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->thumb_img->getClientOriginalExtension();
                $request->thumb_img->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $advertising->preroll_thumbimg = $file;
            }
        }


        $advertising->save();

        Session::flash('success', 'The new Advertising was successfully added!');

        return redirect()->route('advertising.index');


    }

    public function createBgAds(Request $request)
    {
        $this->validate($request, array(
            'preroll_name' => 'required',
            'preroll_type' => 'required',
            'preroll_goto_link' => 'required',
            'thumb_img' => 'required'
        ));

        $advertising = new Advertising;

        $advertising->preroll_name = $request->preroll_name;
        $advertising->preroll_type = $request->preroll_type;
        $advertising->preroll_goto_link = $request->preroll_goto_link;

        $advertising->preroll_thumbimg = '';

        if($request->thumb_img != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->thumb_img->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->thumb_img->getClientOriginalExtension();
                $request->thumb_img->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $advertising->preroll_thumbimg = $file;
            }
        }


        $advertising->save();

        Session::flash('success', 'The new Advertising was successfully added!');

        return redirect()->route('advertising.index');

    }

    public function createBannerAds(Request $request)
    {

        $bannerads = BannerAdvertising::where('id', 1)->first();

        $bannerads->link = $request->link;
        $bannerads->client = $request->client;
        $bannerads->slot = $request->slot;
        $bannerads->type = $request->ads_type;
        $bannerads->public = 1;

        if($request->img != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img->getClientOriginalExtension();
                $request->img->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads->image = $file;
            }
        }


        $bannerads->save();

        Session::flash('success', 'The new Banner Advertising was successfully added!');

        return redirect()->route('advertising.index');
    }

    public function createBannerAdsNews1(Request $request)
    {

        $bannerads = BannerAdvertising::where('id', 2)->first();

        $bannerads->client = $request->client;
        $bannerads->slot = $request->slot;
        $bannerads->save();

        Session::flash('success', 'The new Banner Advertising was successfully added!');

        return redirect()->route('advertising.index');
    }

    public function createBannerAdsLeft(Request $request)
    {

        $bannerads = BannerAdvertising::where('id', 3)->first();
        $bannerads->title = $request->title;
        $bannerads->description = $request->description;
        $bannerads->link = $request->url;
        $bannerads->public = $request->left_pub;
        if($request->img != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img->getClientOriginalExtension();
                $request->img->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads->image = $file;
            }
        }
        $bannerads->save();

        $bannerads1_2 = BannerAdvertising::where('id', 14)->first();
        $bannerads1_2->title = $request->title1_2;
        $bannerads1_2->description = $request->description1_2;
        $bannerads1_2->link = $request->url1_2;
        $bannerads1_2->public = $request->left1_2_pub;
        if($request->img1_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img1_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img1_2->getClientOriginalExtension();
                $request->img1_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads1_2->image = $file;
            }
        }
        $bannerads1_2->save();

        $bannerads2 = BannerAdvertising::where('id', 4)->first();
        $bannerads2->title = $request->title2;
        $bannerads2->description = $request->description2;
        $bannerads2->link = $request->url2;
        $bannerads2->public = $request->left_pub2;
        if($request->img2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2->getClientOriginalExtension();
                $request->img2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads2->image = $file;
            }
        }
        $bannerads2->save();

        $bannerads2_2 = BannerAdvertising::where('id', 15)->first();
        $bannerads2_2->title = $request->title2_2;
        $bannerads2_2->description = $request->description2_2;
        $bannerads2_2->link = $request->url2_2;
        $bannerads2_2->public = $request->left_pub2_2;
        if($request->img2_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img2_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2_2->getClientOriginalExtension();
                $request->img2_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads2_2->image = $file;
            }
        }
        $bannerads2_2->save();

        $bannerads3 = BannerAdvertising::where('id', 16)->first();
        $bannerads3->title = $request->title3;
        $bannerads3->description = $request->description3;
        $bannerads3->link = $request->url3;
        $bannerads3->public = $request->left_pub3;
        if($request->img3 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img3->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img3->getClientOriginalExtension();
                $request->img3->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads3->image = $file;
            }
        }
        $bannerads3->save();

        $bannerads3_2 = BannerAdvertising::where('id', 17)->first();
        $bannerads3_2->title = $request->title3_2;
        $bannerads3_2->description = $request->description3_2;
        $bannerads3_2->link = $request->url3_2;
        $bannerads3_2->public = $request->left_pub3_2;
        if($request->img3_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img3_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2_2->getClientOriginalExtension();
                $request->img3_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads3_2->image = $file;
            }
        }
        $bannerads3_2->save();

        Session::flash('success', 'The new Banner Advertising was successfully added!');

        return redirect()->route('advertising.index');
    }

    public function createBannerAdsRight(Request $request)
    {

        $bannerads = BannerAdvertising::where('id', 5)->first();

        $bannerads->title = $request->title;
        $bannerads->description = $request->description;
        $bannerads->link = $request->url;
        $bannerads->public = $request->right_pub;
        if($request->img != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img->getClientOriginalExtension();
                $request->img->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads->image = $file;
            }
        }
        $bannerads->save();

        $bannerads1_2 = BannerAdvertising::where('id', 8)->first();

        $bannerads1_2->title = $request->title1_2;
        $bannerads1_2->description = $request->description1_2;
        $bannerads1_2->link = $request->url1_2;
        $bannerads1_2->public = $request->right1_2_pub;
        if($request->img1_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img1_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img1_2->getClientOriginalExtension();
                $request->img1_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads1_2->image = $file;
            }
        }
        $bannerads1_2->save();

        $bannerads1_3 = BannerAdvertising::where('id', 9)->first();

        $bannerads1_3->title = $request->title1_3;
        $bannerads1_3->description = $request->description1_3;
        $bannerads1_3->link = $request->url1_3;
        $bannerads1_3->public = $request->right1_3_pub;
        if($request->img1_3 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img1_3->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img1_3->getClientOriginalExtension();
                $request->img1_3->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads1_3->image = $file;
            }
        }
        $bannerads1_3->save();

        $bannerads2 = BannerAdvertising::where('id', 6)->first();

        $bannerads2->title = $request->title2;
        $bannerads2->description = $request->description2;
        $bannerads2->link = $request->url2;
        $bannerads2->public = $request->right_pub2;
        if($request->img2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2->getClientOriginalExtension();
                $request->img2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads2->image = $file;
            }
        }
        $bannerads2->save();

        $bannerads2_2 = BannerAdvertising::where('id', 10)->first();
        $bannerads2_2->title = $request->title2_2;
        $bannerads2_2->description = $request->description2_2;
        $bannerads2_2->link = $request->url2_2;
        $bannerads2_2->public = $request->right2_2_pub;
        if($request->img2_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img2_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2_2->getClientOriginalExtension();
                $request->img2_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads2_2->image = $file;
            }
        }
        $bannerads2_2->save();

        $bannerads2_3 = BannerAdvertising::where('id', 11)->first();
        $bannerads2_3->title = $request->title2_3;
        $bannerads2_3->description = $request->description2_3;
        $bannerads2_3->link = $request->url2_3;
        $bannerads2_3->public = $request->right2_3_pub;
        if($request->img2_3 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img2_3->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img2_3->getClientOriginalExtension();
                $request->img2_3->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads2_3->image = $file;
            }
        }
        $bannerads2_3->save();

        $bannerads3 = BannerAdvertising::where('id', 7)->first();

        $bannerads3->title = $request->title3;
        $bannerads3->description = $request->description3;
        $bannerads3->link = $request->url3;
        $bannerads3->public = $request->right_pub3;
        if($request->img3 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img3->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img3->getClientOriginalExtension();
                $request->img3->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads3->image = $file;
            }
        }
        $bannerads3->save();

        $bannerads3_2 = BannerAdvertising::where('id', 12)->first();
        $bannerads3_2->title = $request->title3_2;
        $bannerads3_2->description = $request->description3_2;
        $bannerads3_2->link = $request->url3_2;
        $bannerads3_2->public = $request->right3_2_pub;
        if($request->img3_2 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img3_2->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img3_2->getClientOriginalExtension();
                $request->img3_2->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads3_2->image = $file;
            }
        }
        $bannerads3_2->save();

        $bannerads3_3 = BannerAdvertising::where('id', 13)->first();
        $bannerads3_3->title = $request->title3_3;
        $bannerads3_3->description = $request->description3_3;
        $bannerads3_3->link = $request->url3_3;
        $bannerads3_3->public = $request->right3_3_pub;
        if($request->img3_3 != null){
            $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
            if(in_array($request->img3_3->getClientOriginalExtension(), $img_val_array)){
                $file = uniqid().'.'.$request->img3_3->getClientOriginalExtension();
                $request->img3_3->move(public_path('ad_up/images'), $file);
                $image = public_path('ad_up/images/').$file;
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                unlink($image);
                $bannerads3_3->image = $file;
            }
        }
        $bannerads3_3->save();

        Session::flash('success', 'The new Banner Advertising was successfully added!');

        return redirect()->route('advertising.index');
    }




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
        $ads = Advertising::find($id);
        return view('admin.advertising.edit', compact('ads'));
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

        if($request->preroll_type == 'channel_bg'){

            $this->validate($request, array(
                'preroll_name' => 'required',
                'preroll_type' => 'required',
                'preroll_goto_link' => 'required',
            ));

            $advertising = Advertising::find($id);
            $advertising->preroll_name = $request->preroll_name;
            $advertising->preroll_type = $request->preroll_type;
            $advertising->preroll_goto_link = $request->preroll_goto_link;

            if($request->thumb_img != null){
                $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
                if(in_array($request->thumb_img->getClientOriginalExtension(), $img_val_array)){
                    $file = uniqid().'.'.$request->thumb_img->getClientOriginalExtension();
                    $request->thumb_img->move(public_path('ad_up/images'), $file);
                    $image = public_path('ad_up/images/').$file;
                    $s3 = Storage::disk('s3frenvid');
                    $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                    unlink($image);
                    if($advertising->preroll_thumbimg){
                        $del_path = '/ads/images/'.$advertising->preroll_thumbimg;
                        if(Storage::disk('s3frenvid')->exists($del_path)) {
                            Storage::disk('s3frenvid')->delete($del_path);
                        }
                    }
                    $advertising->preroll_thumbimg = $file;
                }
            }

            $advertising->save();
            Session::flash('success', 'Your change was successfully added!');

            //redirect

            return redirect()->route('advertising.index');

        }
        else{

            $this->validate($request, array(
                'preroll_name' => 'required',
                'preroll_type' => 'required',
                'preroll_goto_link' => 'required',
                'preroll_skip_timer' => 'required'
            ));

            $advertising = Advertising::find($id);
            $advertising->preroll_name = $request->preroll_name;
            $advertising->preroll_type = $request->preroll_type;
            $advertising->preroll_goto_link = $request->preroll_goto_link;
            $advertising->preroll_skip_timer = $request->preroll_skip_timer;


            if($request->preroll_mp4 != null){
                if($request->preroll_mp4->getClientOriginalExtension() == 'mp4'){
                    $file = uniqid().'v.'.$request->preroll_mp4->getClientOriginalExtension();
                    $request->preroll_mp4->move(public_path('ad_up/videos'), $file);
                    $video = public_path('ad_up/videos/').$file;
                    $s3 = Storage::disk('s3frenvid');
                    $s3->put('/ads/videos/'.$file, file_get_contents($video), 'public');
                    unlink($video);
                    if($advertising->preroll_mp4){
                        $del_path = '/ads/videos/'.$advertising->preroll_mp4;
                        if(Storage::disk('s3frenvid')->exists($del_path)) {
                            Storage::disk('s3frenvid')->delete($del_path);
                        }
                    }
                    $advertising->preroll_mp4 = $file;
                }
            }


            if($request->thumb_img != null){
                $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
                if(in_array($request->thumb_img->getClientOriginalExtension(), $img_val_array)){
                    $file = uniqid().'.'.$request->thumb_img->getClientOriginalExtension();
                    $request->thumb_img->move(public_path('ad_up/images'), $file);
                    $image = public_path('ad_up/images/').$file;
                    $s3 = Storage::disk('s3frenvid');
                    $s3->put('/ads/images/'.$file, file_get_contents($image), 'public');
                    unlink($image);
                    if($advertising->preroll_thumbimg){
                        $del_path = '/ads/images/'.$advertising->preroll_thumbimg;
                        if(Storage::disk('s3frenvid')->exists($del_path)) {
                            Storage::disk('s3frenvid')->delete($del_path);
                        }
                    }
                    $advertising->preroll_thumbimg = $file;
                }
            }

            $advertising->save();
            Session::flash('success', 'Your change was successfully added!');

            //redirect

            return redirect()->route('advertising.index');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ads = Advertising::find($id);

        $del_img_path = '/ads/images/'.$ads->preroll_thumbimg;
        if(Storage::disk('s3frenvid')->exists($del_img_path)) {
            Storage::disk('s3frenvid')->delete($del_img_path);
        }

        $del_video_path = '/ads/videos/'.$ads->preroll_mp4;
        if(Storage::disk('s3frenvid')->exists($del_video_path)) {
            Storage::disk('s3frenvid')->delete($del_video_path);
        }

        Videos::where('ads_id', $id)->update(['ads_id' =>  0]);
        Channel::where('ads_id', $id)->update(['ads_id' =>  0]);

        $ads->delete();

        // redirect
        Session::flash('message', 'Advertising Successfully deleted!');
        return redirect()->route('advertising.index');
    }
}
