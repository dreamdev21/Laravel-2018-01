<?php

namespace App\Http\Controllers;

use App\EmailSettings;
use App\Movie;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class AdminEmailController extends Controller
{
    public function index(){
        $movies = Movie::orderBy('title','asc')->get(['id','title','description','poster','slug'])->toArray();
        $emails['registration'] = EmailSettings::where('type','registration')->first()->toArray();
        $emails['registration']['message'] = str_replace('%USER%','User', $emails['registration']['message']);
        $emails['movie_0'] = EmailSettings::where([['type','movie'],['reg_id',0]])->first()->toArray();
        $emails['movie_1'] = EmailSettings::where([['type','movie'],['reg_id',1]])->first()->toArray();
        $emails['movie_2'] = EmailSettings::where([['type','movie'],['reg_id',2]])->first()->toArray();
        $emails['movie_3'] = EmailSettings::where([['type','movie'],['reg_id',3]])->first()->toArray();
        $movie_1 = Movie::find($emails['movie_1']['movie_id']);
        if($movie_1) $emails['movie_1']['movie'] = $movie_1->toArray();
        else $emails['movie_1']['movie'] = null;
        $movie_2 = Movie::find($emails['movie_2']['movie_id']);
        if($movie_2) $emails['movie_2']['movie'] = $movie_2->toArray();
        else $emails['movie_2']['movie'] = null;
        $movie_3 = Movie::find($emails['movie_3']['movie_id']);
        if($movie_3) $emails['movie_3']['movie'] = $movie_3->toArray();
        else $emails['movie_3']['movie'] = null;
        return view('admin.email.email')->with('emails',$emails)->with('movies',$movies);
    }

    public function saveRegEmail(Request $request){
        $reg_email = EmailSettings::where('type','registration')->first();
        if($request->hasFile('reg_image')){
            $cover = $request->file('reg_image');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->save( public_path('assets/images/' . $filename));
            $reg_email->image = $filename;
            $s3 = Storage::disk('s3frenvid');
            $s3->put('/email/images/'.$filename, file_get_contents(public_path('assets/images/' . $filename)), 'public');
            unlink(public_path('assets/images/' . $filename));
        }
        if($request->has('reg_title')) $reg_email->title = $request->input('reg_title');
        if($request->has('reg_message')) $reg_email->message = $request->input('reg_message');
        if($request->has('reg_url')) $reg_email->url = $request->input('reg_url');
        $reg_email->save();
        $this->sendRegEmail();
        return redirect()->back();
    }

    public function saveMovieEmail(Request $request){
        $mov_email = EmailSettings::where([['type','movie'],['reg_id',0]])->first();
        if($request->has('mov_message'))$mov_email->message = $request->input('mov_message');
        if($request->has('mov_url')) $mov_email->url = $request->input('mov_url');
        if($request->hasFile('mov_image')){
            $cover = $request->file('mov_image');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->save( public_path('assets/images/' . $filename));
            $mov_email->image = $filename;
            $s3 = Storage::disk('s3frenvid');
            $s3->put('/email/images/'.$filename, file_get_contents(public_path('assets/images/' . $filename)), 'public');
            unlink(public_path('assets/images/' . $filename));
        }
        if($request->has('sheduling')) $mov_email->active = true;
        else $mov_email->active = false;
        if($request->has('mov_title')) $mov_email->title = $request->input('mov_title');
        if($request->has('date')){
            $date = Carbon::parse($request->input('date'));
            $mov_email->date = $date;
        }
        $mov_email->save();
        if($request->has('movie_1') && ($request->input('movie_1') !== 'none')){
            $email = EmailSettings::where([['type','movie'],['reg_id',1]])->first();
            $email->movie_id = $request->input('movie_1');
            $mov = Movie::find($email->movie_id);
            if(($email->image !== $mov->poster) && !empty($mov)){
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/email/images/'.$mov->poster, file_get_contents(public_path('assets/images/' . $mov->poster)), 'public');
                $email->image = $mov->poster;
            }
            $email->save();
        }
        elseif ($request->has('movie_1') && ($request->input('movie_1') === 'none')){
            $email = EmailSettings::where([['type','movie'],['reg_id',1]])->first();
            $email->movie_id = -1;
            $email->save();
        }
        if(($request->has('movie_2') && ($request->input('movie_2') !== 'none'))){
            $email = EmailSettings::where([['type','movie'],['reg_id',2]])->first();
            $email->movie_id = $request->input('movie_2');
            $mov = Movie::find($email->movie_id);
            if(($email->image !== $mov->poster) && !empty($mov)){
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/email/images/'.$mov->poster, file_get_contents(public_path('assets/images/' . $mov->poster)), 'public');
                $email->image = $mov->poster;
            }
            $email->save();
        }
        elseif ($request->has('movie_2') && ($request->input('movie_2') === 'none')){
            $email = EmailSettings::where([['type','movie'],['reg_id',2]])->first();
            $email->movie_id = -1;
            $email->save();
        }
        if(($request->has('movie_3')) && ($request->input('movie_3') !== 'none')){
            $email = EmailSettings::where([['type','movie'],['reg_id',3]])->first();
            $email->movie_id = $request->input('movie_3');
            $mov = Movie::find($email->movie_id);
            if(($email->image !== $mov->poster) && !empty($mov)){
                $s3 = Storage::disk('s3frenvid');
                $s3->put('/email/images/'.$mov->poster, file_get_contents(public_path('assets/images/' . $mov->poster)), 'public');
                $email->image = $mov->poster;
            }
            $email->save();
        }
        elseif ($request->has('movie_3') && ($request->input('movie_3') === 'none')){
            $email = EmailSettings::where([['type','movie'],['reg_id',3]])->first();
            $email->movie_id = -1;
            $email->save();
        }
        if($request->has('send')) self::sendEmails();
        return redirect()->back();
    }

    public static function sendEmails(){
        $users = User::where('role','3')->get();
        $emails['movie_0'] = EmailSettings::where([['type','movie'],['reg_id',0]])->first()->toArray();
        $emails['movie_1'] = EmailSettings::where([['type','movie'],['reg_id',1]])->first()->toArray();
        $emails['movie_2'] = EmailSettings::where([['type','movie'],['reg_id',2]])->first()->toArray();
        $emails['movie_3'] = EmailSettings::where([['type','movie'],['reg_id',3]])->first()->toArray();
        $movie_1 = Movie::find($emails['movie_1']['movie_id']);
        if($movie_1) $emails['movie_1']['movie'] = $movie_1->toArray();
        else $emails['movie_1']['movie'] = null;
        $movie_2 = Movie::find($emails['movie_2']['movie_id']);
        if($movie_2) $emails['movie_2']['movie'] = $movie_2->toArray();
        else $emails['movie_2']['movie'] = null;
        $movie_3 = Movie::find($emails['movie_3']['movie_id']);
        if($movie_3) $emails['movie_3']['movie'] = $movie_3->toArray();
        else $emails['movie_3']['movie'] = null;
        foreach ($users as $user){
            $usemail = $user->email;
            if(!empty($user->email)){
                Mail::send('emails.movie', [
                    'image_0' => \Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_0']['image']),
                    'message_0' => $emails['movie_0']['message'],
                    'url_0' => $emails['movie_0']['url'],
                    'title_0' => $emails['movie_0']['title'],
                    'movie_1' => $emails['movie_1']['movie'],
                    'image_1' => $emails['movie_1']['image'],
                    'movie_2' => $emails['movie_2']['movie'],
                    'image_2' => $emails['movie_2']['image'],
                    'movie_3' => $emails['movie_3']['movie'],
                    'image_3' => $emails['movie_3']['image']
                ], function ($message) use ($usemail) {
                    $message->to($usemail)
                        ->subject('Movie');
                });
            }
        }
    }

    public static function autoSend(){
        $settings = EmailSettings::where('type','movie')->first();
        $date = $settings->date;
        $date = Carbon::parse($date);
        $active = $settings->active;
        $now = Carbon::now();
        if($date->gt($now) && $active){
            $settings->active = false;
            $settings->save();
            self::sendEmails();
        }
    }

    public function getMovie($id){
        $movie = Movie::find($id);
        return $movie;
    }

    public function sendRegEmail(){
        $email = EmailSettings::where('type','registration')->first()->toArray();
        $users = User::where('role','3')->get();
        foreach ($users as $user){
            $email['message'] = str_replace('%USER%', $user['username'], $email['message']);
            $usemail = $user->email;
            Mail::send('emails.registration', [
                'image' => Storage::disk('s3frenvid')->url('email/images/'.$email['image']),
                'title' => $email['title'],
                'text' => $email['message'],
                'link' => $email['url'],
                'name' => $user['name']
            ], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Registration');
            });
        }
    }
}
