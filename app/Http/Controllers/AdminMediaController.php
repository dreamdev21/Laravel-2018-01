<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Studio;
use App\Genre;
use App\Director;

class AdminMediaController extends Controller
{
    public function index()
    {

        $directories = Storage::disk('s3frenvid');

//        dd($directories->allFiles());
        $stud_file_array = array();

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

            return view('admin.media.prodindex', compact('studios', 'studios_all', 'directors', 'genres'));
        }
        else{
            $studios = Studio::get();
            foreach ($studios as $studio){
                $stud_file_array[$studio->name]['trailer']  = $directories->allFiles('/uploads/'.$studio->name.'/trailer/');
                $stud_file_array[$studio->name]['film']     = $directories->allFiles('/uploads/'.$studio->name.'/film/');
                $stud_file_array[$studio->name]['image']    = $directories->allFiles('/uploads/'.$studio->name.'/image/');
            }
            return view('admin.media.index', compact('stud_file_array', 'studios'));
        }

    }

    public function add_file(Request $request)
    {
        ini_set('max_execution_time', 0);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $fpath = '';

        if ($request->s3_up_type == 'trailer'){
            $fpath = 'uploads/'.$request->s3_up_studio.'/trailer/';
        }
        else if($request->s3_up_type == 'image'){
            $fpath = 'uploads/'.$request->s3_up_studio.'/images/';
        }
        else{
            $fpath = 'uploads/'.$request->s3_up_studio.'/films/';
        }




        $directories = Storage::disk('s3frenvid');

        if($request->s3_up_file != null){

            if($request->s3_up_file->getClientOriginalExtension() == 'mp4'){
                $file = rand(0,9999).'_'.$request->s3_up_file->getClientOriginalName();
                $request->s3_up_file->move(public_path('ad_up/'), $file);
                $video = public_path('ad_up/').$file;
                $url = env('APP_URL').':3000/upload';
                $data = array('tmp_f' => $video, 'f_path' => $fpath.$file);
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                exit;
            }

            if($request->s3_up_type == 'image'){

                $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];

                if(in_array($request->s3_up_file->getClientOriginalExtension(), $img_val_array)){
                    $file = rand(0,9999).'_'.$request->s3_up_file->getClientOriginalName();
                    $request->s3_up_file->move(public_path('ad_up/'), $file);
                    $video = public_path('ad_up/').$file;
                    $url = env('APP_URL').':3000/upload';
                    $data = array('tmp_f' => $video, 'f_path' => $fpath.$file);
                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context  = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);
                    exit;
                }

            }

        }

        return redirect()->route('media.index');


    }

    public function store(Request $request)
    {

        ini_set('max_execution_time', 0);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $fpath = '';

        if ($request->m_type == 'trailer'){
            $fpath = '/uploads/'.$request->studio.'/trailer/';
        }
        else if($request->m_type == 'image'){
            $fpath = '/uploads/'.$request->studio.'/images/';
        }
        else{
            $fpath = '/uploads/'.$request->studio.'/films/';
        }



        $directories = Storage::disk('s3frenvid');
        if($request->movie_mp4 != null){

            if($request->movie_mp4->getClientOriginalExtension() == 'mp4'){
                $file = rand(0,9999).'_'.$request->movie_mp4->getClientOriginalName();
                $request->movie_mp4->move(public_path('ad_up/'), $file);
                $video = public_path('ad_up/').$file;
                $directories->put($fpath.$file, file_get_contents($video), 'public');
                unlink($video);
            }

            if($request->m_type == 'image'){

                $img_val_array = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'gif'];
                if(in_array($request->movie_mp4->getClientOriginalExtension(), $img_val_array)){
                    $file = rand(0,9999).'_'.$request->movie_mp4->getClientOriginalName();
                    $request->movie_mp4->move(public_path('ad_up/'), $file);
                    $video = public_path('ad_up/').$file;
                    $directories->put($fpath.$file, file_get_contents($video), 'public');
                    unlink($video);
                }

            }

        }

        return redirect()->route('media.index');


    }

    public function del_s3_file(Request $request)
    {

        $del_url = $request->delurl;
        if(Storage::disk('s3frenvid')->exists($del_url)) {
            $del_res = Storage::disk('s3frenvid')->delete($del_url);
            echo $del_res;
            exit;
        }
    }

    public function getLastUploadetFile(Request $request)
    {
        $st_type = $request->getlast_update;
        $studio = Studio::where('id', Auth::user()->studio_id)->first();
        $directories = Storage::disk('s3frenvid');
        $all_films = $directories->allFiles('/uploads/'.$studio->name.'/'.$st_type.'/');
        $end_films = $directories->url(end($all_films));
        echo $end_films;
        exit;
    }

}
