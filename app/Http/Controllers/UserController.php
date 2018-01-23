<?php

namespace App\Http\Controllers;

use App\BannerAdvertising;
use App\Subscription;
use App\SubscriptionPlan;
use Illuminate\Http\Request;
use App\User;
use App\Watchlist;
use App\Movie;
use Illuminate\Support\Facades\Mail;
use App\Follow;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function settings()
    {
        return view ('user.settings');
    }

    public function enterEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        if(Session::has('reg_res')){
            if(User::where('email',$request->email)->count() > 0){
                return redirect()->back();
            }
            $itemArray = Session::get('reg_res');
            $itemArray['email'] = $request->email;
            User::create($itemArray);
            $email = $request->email;
            Mail::send('emails.reg', ['name' => $itemArray['name'], 'username' => $itemArray['username'], 'email' => $email], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Registration');
            });
            $user = User::where('email', $email)->first();
            auth()->login($user);
            return redirect()->to('/home');
        }


    }

    public function userSettingChatHistory(){
        $user = Auth::user();
        if($user->chat_history == 0) $user->chat_history = 1;
        else $user->chat_history = 0;
        $user->save();
        return redirect()->back();
    }

    //public function profile(User $user){
    //Auth::user();}

    public function profile($name)
    {

        $user = User::where('username', $name)->first();

        $followers_res = [];
        $following_res = [];

        $fwers_res = Follow::where('follower_id', $user->id)->get();

        foreach ($fwers_res as $fwers_res_val){
            $followers_res[] = User::where('id', $fwers_res_val->user_id)->first();
        }

        $fwing_res = Follow::where('user_id', $user->id)->get();
        foreach ($fwing_res as $fwing_res_val){
            $following_res[] = User::where('id', $fwing_res_val->follower_id)->first();
        }
        $followers_res = count($followers_res);
        $following_res = count($following_res);


        $all_fol_users = [];
        $fol_users = Follow::where('user_id', $user->id)->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', $user->id)->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }
        }



        return view ('user.profile', compact('user', 'followers_res', 'following_res', 'all_fol_users'));
    }

    public function usphone(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:7|numeric'
        ]);
        $phone_number = preg_replace( '/[^0-9]/', '', $request->phone );
        $user = Auth::user();
        $ch_phone = User::where('phone', $phone_number)->first();
        if($ch_phone == null) {
            $user->phone = $phone_number;
            $user->save();
        }

        return redirect()->back();
    }

    public function RemovePhoneArea()
    {
        Session::set('phone_area', 1);
    }

    public function follow(Request $request, User $user)
    {
        if ($request->user()->canFollow($user)) {
            $request->user()->following()->attach($user);

            $usemail = $user->email;

            Mail::send('emails.follow', ['fuser' => Auth::user()->username], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('New Follower');
            });

            $all_f_list = $this->chat_res();
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $url = env('APP_URL').':3000/follow';
            $data = array(
                'event' => 'follow',
                'f_user_fr' => $all_f,
                'f_u_id' => $user->id,
                'f_u_avatar' => $user->avatar,
                'f_u_username' => $user->username,
                'from_u_id' => Auth::id(),
                'from_u_username' => Auth::user()->username,
                'from_u_avatar' => Auth::user()->avatar
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);

            return redirect()->back();

        }

        return redirect()->back();
    }

    public function followById(Request $request)
    {

        $user = User::find($request->id);

        if ($request->user()->canFollow($user)) {
            $request->user()->following()->attach($user);

            $all_f_list = $this->chat_res();
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $url = env('APP_URL').':3000/follow';
            $data = array(
                'event' => 'follow',
                'f_user_fr' => $all_f,
                'f_u_id' => $user->id,
                'f_u_avatar' => $user->avatar,
                'f_u_username' => $user->username,
                'from_u_id' => Auth::id(),
                'from_u_username' => Auth::user()->username,
                'from_u_avatar' => Auth::user()->avatar
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);

            return redirect()->back();

        }

        return redirect()->back();
    }

    public function unfollow(Request $request, User $user)
    {
        if ($request->user()->canUnfollow($user)) {
            $request->user()->following()->detach($user);

//            $url = 'http://localhost:3000/follow';
//            $data = array(
//                'event' => 'unfollow',
//                'f_u_id' => $user->id,
//                'from_u_id' => Auth::id(),
//                'from_u_username' => Auth::user()->username,
//                'from_u_avatar' => Auth::user()->avatar
//            );
//
//            // use key 'http' even if you send the request to https://...
//            $options = array(
//                'http' => array(
//                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//                    'method'  => 'POST',
//                    'content' => http_build_query($data)
//                )
//            );
//            $context  = stream_context_create($options);
//            file_get_contents($url, false, $context);
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function updateImage(Request $request)
    {
        //handle user upload of profile image

        if($request->hasFile('avatar')){

            //dd(explode(Auth::user()->avatar, '.'));

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('assets/images/' . $filename));

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return redirect()->back();
    }

    public function updateCoverImage(Request $request)
    {
        //handle user upload of profile cover image

        if($request->hasFile('cover')){

            //dd(explode(Auth::user()->avatar, '.'));

            $cover = $request->file('cover');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->save( public_path('assets/images/' . $filename));

            $user = Auth::user();
            if($user->cover != 'default_cover.jpg'){
                unlink(public_path('assets/images/' . $user->cover));
            }
            $user->cover = $filename;
            $user->save();
        }

        return redirect()->back();
    }

    public function passwordChange(Request $request)
    {

        $user = Auth::user();

        $usemail = $user->email;

        //validate
        $this->validate($request, [
            'oldPassword'           => 'required',
            'newPassword'           => 'required|min:4',
            'password_confirmation' => 'required|same:newPassword'
        ]);

        if (!Hash::check($request->oldPassword, Auth::user()->password)) {
            Session::flash('failed', 'Your current password is not correct');
            return redirect()->back();
        }

        $user->password = Hash::make(Input::get('newPassword'));
        $user->save();

        Mail::send('emails.passchange', [], function ($message) use ($usemail) {
            $message->to($usemail)
                ->subject('Change Password');
        });

        Session::flash('success', 'Your password was successfully updated!');
        return redirect()->back();

    }

    public function disableSavedPayment(Request $request){
        $user = Auth::user();
        $user->card_last_four = null;
        $user->braintree_token = null;
        $user->braintree_id = null;

        $user->save();
        return redirect()->back();

    }

    public function cancel()
    {

        $user = User::find(Auth::user()->id);

        $usemail = $user->email;

        if ($user->delete()) {


            Mail::send('emails.cmship', [], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Cancel Membership');
            });

            Auth::logout();
            return redirect()->route('home')->with('global', 'Your account has been deleted!');

        }

    }

    public static function getwl()
    {
        $reswl = [];
        $wlist = Watchlist::where('user_id', Auth::id())->get();
        if(isset($wlist)){
            foreach ($wlist as $wl){
                $reswl[] = Movie::where('id', $wl->movie_id)->first();
            }
        }
        return $reswl;
    }

    public static function getads()
    {
        $left_ads = [];
        $left_ads['ads_1'] = BannerAdvertising::where('id', 3)->first();
        $left_ads['ads_2'] = BannerAdvertising::where('id', 4)->first();
        $left_ads['ads_3'] = BannerAdvertising::where('id', 16)->first();

        $left_ads['ads_1_2'] = BannerAdvertising::where('id', 14)->first();
        $left_ads['ads_2_2'] = BannerAdvertising::where('id', 15)->first();
        $left_ads['ads_3_2'] = BannerAdvertising::where('id', 17)->first();

        return $left_ads;
    }

    public static function getRightAds()
    {
        $right_ads = [];
        $right_ads['ads_1'] = BannerAdvertising::where('id', 5)->first();
        $right_ads['ads_2'] = BannerAdvertising::where('id', 6)->first();
        $right_ads['ads_3'] = BannerAdvertising::where('id', 7)->first();

        $right_ads['ads_1_2'] = BannerAdvertising::where('id', 8)->first();
        $right_ads['ads_1_3'] = BannerAdvertising::where('id', 9)->first();

        $right_ads['ads_2_2'] = BannerAdvertising::where('id', 10)->first();
        $right_ads['ads_2_3'] = BannerAdvertising::where('id', 11)->first();

        $right_ads['ads_3_2'] = BannerAdvertising::where('id', 12)->first();
        $right_ads['ads_3_3'] = BannerAdvertising::where('id', 13)->first();

//        dd($right_ads);

        return $right_ads;
    }

    public static function chat_res()
    {
        $all_fol_users = [];
        $fol_users = Follow::where('user_id', Auth::id())->get();
        foreach ($fol_users as $val){
            $get_fr = Follow::where('user_id', $val->follower_id)->where('follower_id', Auth::id())->first();

            if(!empty($get_fr->user_id)){
                $all_fol_users[] = User::where('id', $get_fr->user_id)->first();
            }

        }

        return $all_fol_users;
    }

    public static function followInRight()
    {
        $followers = Follow::select('follower_id')->where('user_id',Auth::user()->id)->get()->toArray();
        $user = User::where('id','!=',Auth::user()->id)->where('role',3)->whereNotIn('id',$followers)->inRandomOrder()->first();
        return $user;
    }

    public function checkFollow(Request $request)
    {
        echo Follow::where('user_id', Auth::user()->id)->where('follower_id', $request->from_id)->first();
    }

    public function lastW(Request $request)
    {
        $user = Auth::user();
        $user->last_watched_video = $request->last_w;
        $user->save();
    }

    public function makeSubscription(){
        $basic = SubscriptionPlan::find(1);
        $basic->amount = $basic->amount/100;
        $pro = SubscriptionPlan::find(2);
        $pro->amount = $pro->amount/100;
        $trial_used = true;
        $subscription = Subscription::where([['user_id', Auth::user()->id],['subscription_type','trial']])->first();
        if(!$subscription) $trial_used = false;
        return view('tv.make-subscription', compact('basic', 'pro', 'trial_used'));
    }

    public function userId(){
        return Auth::user()->id;
    }
}
