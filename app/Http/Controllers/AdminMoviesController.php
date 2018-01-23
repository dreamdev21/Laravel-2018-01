<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Genre;
use App\Parental;
use Illuminate\Http\Request;
use App\Studio;
use App\Director;
use App\Actor;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Psr7\Stream;
use App\Payment;




class AdminMoviesController extends Controller
{

    public function index()
    {
//        $timezones = [
//        "America/Anguilla","America/Port_of_Spain","America/Antigua","America/Port_of_Spain","America/Asuncion","America/Atikokan","America/Barbados","America/Belize","America/Blanc-Sablon",
//            "America/Bogota","America/Cambridge_Bay","America/Caracas","America/Cayenne","America/Cayman","America/Panama","America/Coral_Harbour","America/Atikokan","America/Costa_Rica",
//            "America/Danmarkshavn","America/Dawson","America/Dawson_Creek","America/Denver","America/Dominica","America/Port_of_Spain","America/Edmonton","America/El_Salvador",
//            "America/Fort_Nelson","America/Godthab","America/Grand_Turk","America/Grenada","America/Port_of_Spain","America/Guadeloupe","America/Port_of_Spain","America/Guatemala",
//            "America/Guayaquil","America/Guyana","America/Hermosillo","America/Inuvik","America/Iqaluit","America/Jamaica","America/La_Paz","America/Lima","America/Managua",
//            "America/Marigot","America/Port_of_Spain","America/Martinique","America/Mazatlan","America/Miquelon","America/Montserrat","America/Port_of_Spain","America/Nassau",
//            "America/New_York","America/Nipigon","America/Nome","America/Panama","America/Pangnirtung","America/Paramaribo","America/Phoenix","America/Port_of_Spain","America/Port-au-Prince",
//            "America/Puerto_Rico","America/Rankin_Inlet","America/Resolute","America/Santo_Domingo","America/Scoresbysund","America/Shiprock","America/Denver","America/St_Barthelemy",
//            "America/Port_of_Spain","America/St_Kitts","America/Port_of_Spain","America/St_Lucia","America/Port_of_Spain","America/St_Thomas","America/Port_of_Spain","America/St_Vincent",
//            "America/Port_of_Spain","America/Swift_Current","America/Tegucigalpa","America/Thule","America/Thunder_Bay","America/Tortola","America/Port_of_Spain","America/Virgin","America/Port_of_Spain",
//            "America/Whitehorse","America/Winnipeg","America/Yakutat","America/Yellowknife","Antarctica/McMurdo","Pacific/Auckland","Antarctica/South_Pole","Pacific/Auckland","Antarctica/Troll",
//            "Asia/Aden","Asia/Riyadh","Asia/Atyrau","Asia/Baghdad","Asia/Bahrain","Asia/Qatar","Asia/Baku","Asia/Barnaul","Asia/Beirut","Asia/Bishkek","Asia/Brunei","Asia/Chita","Asia/Damascus",
//            "Asia/Dili","Asia/Dushanbe","Asia/Famagusta","Asia/Gaza","Asia/Hebron","Asia/Ho_Chi_Minh","Asia/Jerusalem","Asia/Kabul","Asia/Kuala_Lumpur","Asia/Kuching","Asia/Kuwait","Asia/Riyadh",
//            "Asia/Macao","Asia/Macau","Asia/Macau","Asia/Manila","Asia/Nicosia","Asia/Novokuznetsk","Asia/Qatar","Asia/Riyadh","Asia/Saigon","Asia/Ho_Chi_Minh","Asia/Samarkand","Asia/Singapore",
//            "Asia/Tbilisi","Asia/Tel_Aviv","Asia/Jerusalem","Asia/Tomsk","Atlantic/Bermuda","Atlantic/Cape_Verde","Atlantic/Faeroe","Atlantic/Faroe","Atlantic/Faroe","Atlantic/Reykjavik",
//            "Atlantic/South_Georgia","Atlantic/Stanley","Canada/Central","America/Winnipeg","Canada/Mountain","America/Edmonton","Canada/Yukon","America/Whitehorse","Eire","Europe/Dublin",
//            "Europe/Andorra","Europe/Astrakhan","Europe/Bratislava","Europe/Prague","Europe/Chisinau","Europe/Dublin","Europe/Gibraltar","Europe/Kirov","Europe/Luxembourg","Europe/Monaco",
//            "Europe/Nicosia","Asia/Nicosia","Europe/Prague","Europe/Saratov","Europe/Sofia","Europe/Stockholm","Europe/Tallinn","Europe/Tirane","Europe/Tiraspol","Europe/Chisinau","Europe/Vienna",
//            "Europe/Vilnius","Iceland","Atlantic/Reykjavik","Indian/Chagos","Indian/Christmas","Indian/Cocos","Indian/Kerguelen","Indian/Mahe","Indian/Maldives","Indian/Mauritius","Indian/Reunion",
//            "Israel","Asia/Jerusalem","Jamaica","America/Jamaica","Pacific/Kwajalein","Mexico/BajaSur","America/Mazatlan","Navajo","America/Denver","NZ","Pacific/Auckland","NZ-CHAT","Pacific/Chatham",
//            "Pacific/Apia","Pacific/Auckland","Pacific/Bougainville","Pacific/Chatham","Pacific/Chuuk","Pacific/Efate","Pacific/Enderbury","Pacific/Fakaofo","Pacific/Fiji","Pacific/Funafuti",
//            "Pacific/Galapagos","Pacific/Gambier","Pacific/Guadalcanal","Pacific/Guam","Pacific/Honolulu","Pacific/Johnston","Pacific/Honolulu","Pacific/Kosrae","Pacific/Kwajalein","Pacific/Majuro",
//            "Pacific/Marquesas","Pacific/Midway","Pacific/Pago_Pago","Pacific/Nauru","Pacific/Niue","Pacific/Norfolk","Pacific/Noumea","Pacific/Pago_Pago","Pacific/Palau","Pacific/Pitcairn",
//            "Pacific/Pohnpei","Pacific/Ponape","Pacific/Pohnpei","Pacific/Port_Moresby","Pacific/Rarotonga","Pacific/Saipan","Pacific/Guam","Pacific/Samoa","Pacific/Pago_Pago","Pacific/Tahiti",
//            "Pacific/Tarawa","Pacific/Truk","Pacific/Chuuk","Pacific/Wake","Pacific/Wallis","Pacific/Yap","Pacific/Chuuk","Singapore","Asia/Singapore","US/Arizona","America/Phoenix","US/Eastern",
//            "America/New_York","US/Hawaii","Pacific/Honolulu","US/Mountain","America/Denver","US/Samoa","Pacific/Pago_Pago"
//        ];

        $continents = ["America","Europe","Australia","Asia","Africa"];

        $all_pay = [];
        $calcres = 0;
        if(Auth::user()->role == 2){
            $studio = Studio::where('id', Auth::user()->studio_id)->first();
            $movie = Movie::orderBy('created_at', 'DESC')->where('studio_id', Auth::user()->studio_id)->where('type', 'movie')->get();

            foreach ($movie as $val){
                $calcpay = Payment::where('movie_id', $val->id)->get();
                foreach ($calcpay as $cp){
                    $calcres = $calcres + $cp->amount;
                }
                $all_pay['mid_'.$val->id] = $calcres / 100 * $studio->percent;
                $calcres = 0;
            }

        }
        else{
            $movie = Movie::orderBy('created_at', 'DESC')->where('type', 'movie')->get();
        }

        $parental = Parental::get();

        return view('admin.movies.index', compact('movie', 'all_pay', 'continents', 'parental'));
    }

    public function create()
    {
        if(Auth::user()->role == 2){return redirect('/studio/dashboard');}
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


        return view('admin.movies.create', compact(['studios', 'directors', 'genres', 'aws_all_mov_url', 'aws_all_trailer_url']));
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required|max:255',
            'year' => 'required|integer',
            'type' => 'required',
            'description' => 'required',
            'poster' => 'required|image',
            'url' => 'required',
            'price' => 'required|numeric|min:0.1',
            'period' => 'required|integer|min:1',
            'duration' => 'required',
            'director' => 'required|max:255',
            'genre_id' => 'required|max:255',
            'studio_id' => 'required|max:255',
            'bg_poster' => 'image'
        ));
        if($request->type == 'serie'){
            $this->validate($request, array(
                'seasons' => 'required',
                'series' => 'required',
            ));
        }

        $director = implode(",", $request->director);

        //store in database
        $movie = new Movie;

        $movie->title = $request->title;
        $movie->year = $request->year;
        $movie->type = $request->type;
        $movie->description = Purifier::clean($request->description);
        $movie->url = $request->url;
        $movie->trailer = $request->trailer;
        $movie->price = $request->price;
        $movie->period = $request->period;
        $movie->duration = $request->duration;
        $movie->director_id = $director;
        $movie->genre_id = $request->genre_id;
        $movie->studio_id = $request->studio_id;
        $movie->series_id = '';
        $movie->season_id = '';
        if($request->actor[0]){
            $movie->actors = str_replace(',', ', ',$request->actor[0]);
        }
        if($request->type == 'serie'){
            $movie->series_id = $request->series;
            $movie->season_id = $request->seasons;
        }

        if($request->hasFile('poster')){
            $image = $request->file('poster');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);

            Image::make($image)->resize(250, 383)->save($location);

            $oldFilename = $movie->poster;

            $movie->poster = $filename;

            Storage::delete($oldFilename);
        }

        if($request->hasFile('bg_poster')){
            $image = $request->file('bg_poster');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);

            Image::make($image)->save($location);

            $oldFilename = $movie->bg_poster;

            $movie->bg_poster = $filename;

            $s3 = Storage::disk('s3frenvid');
            $s3->put('/movies/bg_images/'.$filename, file_get_contents(public_path('assets/images/' . $filename)), 'public');
            unlink(public_path('assets/images/' . $filename));

            if(Storage::disk('s3frenvid')->exists('assets/images/'.$oldFilename)) {
                Storage::disk('s3frenvid')->delete('assets/images/'.$oldFilename);
            }
        }

        $movie->save();

        Session::flash('success', 'The movie was successfully added!');

        return redirect()->route('movies.index');

    }

    public function show($id)
    {
//        if(Auth::user()->role == 2){return redirect('/studio/dashboard');}
        $movie = Movie::find($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit($id)
    {
//        if(Auth::user()->role == 2){return redirect('/studio/dashboard');}
        //find the movie in the database and save as a variable
        $movie = Movie::find($id);
        if(Auth::user()->id != 1){
            if($movie->studio_id != Auth::user()->studio_id){
                return redirect()->back();
            }
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

        return view('admin.movies.edit', compact('movie', 'aws_all_mov_url', 'aws_all_trailer_url'));
    }

    public function update(Request $request, $id)
    {
//        if(Auth::user()->role == 2){return redirect('/studio/dashboard');
//        }elseif (Auth::user()->role == 1){
            $this->validate($request, array(
                'title' => 'required|max:255',
                'year' => 'required|integer',
                'description' => 'required',
                'poster' => 'image',
                'url' => 'required',
                'price' => 'required|numeric|min:0.1',
                'period' => 'required|integer|min:1',
                'bg_poster' => 'image'
            ));
//        }



        //get movie in database by id

        $movie = Movie::find($id);

        $movie->title = $request->input('title');
        $movie->year = $request->input('year');
        $movie->description = Purifier::clean($request->input('description'));
        $movie->url = $request->input('url');
        $movie->price = $request->input('price');
        $movie->period = $request->input('period');



        if($request->hasFile('poster')){
            $image = $request->file('poster');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);
            Image::make($image)->resize(250, 383)->save($location);

            $oldFilename = $movie->poster;

            $movie->poster = $filename;

            Storage::delete($oldFilename);
        }

        if($request->hasFile('bg_poster')){
            $image = $request->file('bg_poster');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/images/' . $filename);

            Image::make($image)->save($location);

            $oldFilename = $movie->bg_poster;

            $movie->bg_poster = $filename;

            $s3 = Storage::disk('s3frenvid');
            $s3->put('/movies/bg_images/'.$filename, file_get_contents(public_path('assets/images/' . $filename)), 'public');
            unlink(public_path('assets/images/' . $filename));

            if(Storage::disk('s3frenvid')->exists('assets/images/'.$oldFilename)) {
                Storage::disk('s3frenvid')->delete('assets/images/'.$oldFilename);
            }
        }

        $movie->save();

        Session::flash('success', 'The movie was successfully added!');

        return redirect()->route('movies.index', $movie->id);
    }

    public function destroy($id)
    {
//        if(Auth::user()->role == 2){return redirect('/studio/dashboard');}
        $movie = Movie::find($id);
        Storage::delete($movie->poster);
        $movie->delete();

        // redirect
        Session::flash('message', 'Movie Successfully deleted!');
        return redirect()->route('movies.index');
    }

    public function editMovieSlidePub(Request $request)
    {
        $movie = Movie::where('id', $request->movid)->first();
        $movie->slide_public = $request->event_pub;
        $movie->save();
    }

    public function parental(Request $request)
    {
        $mid = $request->m_id;
        $par_id = $request->par_id;
        $movie  = Movie::where('id', $mid)->first();
        $movie->parental_id = $par_id;
        $movie->save();
    }

    public function makePublic(Request $request)
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

    public function geoFencing(Request $request){
        $mid = $request->id;

        $movie  = Movie::where('id', $mid)->first();
        if ($request->geo!=null){
            $geo = implode(",",$request->geo);
            $movie->blacklist = $geo;
        }else{
            $movie->blacklist = null;
        }
        $movie->save();

    }


}
