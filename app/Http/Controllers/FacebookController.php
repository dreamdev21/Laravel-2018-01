<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\SocialAccountService;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Socialite; // socialite namespace

class FacebookController extends Controller
{
    public function login(){
        return Socialite::driver('facebook')->redirect();
    }
    // callback function
    public function callback(){
        $fb_res = Socialite::driver('facebook')->user();
        $fb_avatar = $fb_res->avatar;
        $fb_gender = $fb_res->user['gender'];
        $fb_username = $fb_res->user['name'];
        $fb_name = $fb_res->user['name'];
        $fb_token = $fb_res->token;
        if(isset($fb_res->email)){
            $fb_email = $fb_res->user['email'];
            $au_user = User::where('email', $fb_email)->first();
            if($au_user){
                auth()->login($au_user);
                return redirect()->to('/home');
            }
        }

        if($fb_gender == 'male'){
            $fb_gender = 1;
        }
        else{
            $fb_gender = 2;
        }
        $avatar = file_get_contents($fb_avatar);
        $filename = time() . '.jpg';
        $location = public_path('assets/images/' . $filename);
        Image::make($avatar)->resize(250, 250)->save($location);



        $itemArray['name'] = $fb_name;
        $itemArray['username'] = $fb_username;
        $itemArray['gender'] = $fb_gender;
        $itemArray['password'] = bcrypt($fb_token);
        $itemArray['slug'] = str_slug($fb_name);
        $itemArray['avatar'] = $filename;
        if (isset($fb_res->email)){
            $itemArray['email'] = $fb_res->email;
            User::create($itemArray);
            Mail::send('emails.reg', ['name' => $fb_name, 'username' => $fb_username, 'email' => $fb_email], function ($message) use ($fb_email) {
                $message->to($fb_email)
                    ->subject('Registration');
            });
            $user = User::where('email', $fb_email)->first();
            auth()->login($user);
            return redirect()->to('/home');
        }
        else{
            Session::set('reg_res', $itemArray);
            return view('enteremail');
        }


    }
}
