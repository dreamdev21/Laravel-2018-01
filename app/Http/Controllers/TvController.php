<?php
/**
 * Created by PhpStorm.
 * User: WFMarket2
 * Date: 11.07.2017
 * Time: 18:32
 */

namespace App\Http\Controllers;

use App\Channel;
use App\Payment;
use App\Subscription;
use App\SubscriptionPlan;
use App\User;
use Braintree_Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class TvController extends Controller
{

    public function dashboard()
    {
        return view('tvstation.tv_dashboard');
    }

    public function tvhiw()
    {
        return view('tvstation.tvhiw');
    }

    public function tv_settings()
    {
        $subscription = Subscription::where('user_id',Auth::user()->id)->orderBy('id','desc')->first()->subscription_type;
        $channel = Channel::find(Auth::user()->channel_id);
        $continents = ["America","Europe","Australia","Asia","Africa"];
        return view('tv.settings', compact('continents', 'channel', 'subscription'));
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

    public function bgImageChange(Request $request){

        $this->validate($request, array(
            'thumb_img' => 'required | mimes:jpeg,jpg,png'
        ));

        if($request->hasFile('thumb_img')){
            $channel = Channel::where('id',Auth::user()->channel_id)->first();
            $oldPlayerBgImgName = $channel->logo;

            $avatar = $request->file('thumb_img');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save( public_path('/assets/images/tvstation/' . $filename)); /*->resize(300, 300)*/

            $channel->logo = $filename;
            $channel->save();

            if(file_exists(public_path('/assets/images/tvstation/' . $oldPlayerBgImgName))){
                unlink(public_path('/assets/images/tvstation/' .$oldPlayerBgImgName));
            }

        }



        Session::flash('message', 'Player background image successfully updated!');
        return redirect()->back();
    }

    public function setChannelLogo(Request $request){
        $this->validate($request, array(
            'logo' => 'required | mimes:jpeg,jpg,png'
        ));
        if($request->hasFile('logo')){
            $channel = Channel::where('id',Auth::user()->channel_id)->first();
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)->save( public_path('assets/images/' . $filename));
            $channel->channel_logo = $filename;
            $s3 = Storage::disk('s3frenvid');
            $s3->put('/tv_users/logo/'.Auth::user()->id.'/'.$filename, file_get_contents(public_path('assets/images/' . $filename)), 'public');
            unlink(public_path('assets/images/' . $filename));
            $channel->save();
        }
        Session::flash('message', 'Logo image successfully updated!');
        return redirect()->back();
    }

    public function removeLogo(){
        $channel = Channel::where('id',Auth::user()->channel_id)->first();
        if(!empty($channel->channel_logo)){
            $del_path = '/tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo;
            if(Storage::disk('s3frenvid')->exists($del_path)) {
                Storage::disk('s3frenvid')->delete($del_path);
            }
            $channel->channel_logo = "";
            $channel->save();
            return "Logo successfully removed";
        }
        else return "You have no logo to remove";
    }

    public function setSubscription(Request $request){
        $data = $request->input('data');
        $paymentMethodNonce = $data['nonce'];
        $result = Braintree_Transaction::sale(
            [
                'amount' => floatval($data['amount']),
                'paymentMethodNonce' => $paymentMethodNonce,
                'options' => [
                    'submitForSettlement' => True,
                    'storeInVaultOnSuccess' => True
                ]
            ]
        );
        if ($result->success) {
            $subscription = new Subscription();
            $subscription->user_id = Auth::id();
            $basic = SubscriptionPlan::find(1);
            $basic->amount = $basic->amount/100;
            $pro = SubscriptionPlan::find(2);
            $pro->amount = $pro->amount/100;
            $subscription->payment_id = $result->transaction->id;
            $subscription->amount = $result->transaction->amount;
            if($subscription->amount === strval($basic->amount)) $subscription->subscription_type = "basic";
            elseif($subscription->amount === strval($pro->amount)) $subscription->subscription_type = "pro";
            else return "wrong payment detected";
            $subscription->payment_date = Carbon::now();
            $subscription->save();
            $user = User::find(Auth::user()->id);
            $user->subscription_enabled = true;
            $user->save();
            if($subscription->subscription_type === 'basic'){
                $channel = Channel::find(Auth::user()->channel_id);
                $channel->mid_roll = false;
                $channel->save();
            }
            return 'success';
        }
        else return 'payment error';
    }

    public function setTrial(){
        $user = User::find(Auth::user()->id);
        if(!$user->trial_used){
            $subscription = new Subscription();
            $subscription->user_id = Auth::id();
            $subscription->payment_id = "";
            $subscription->amount = 0;
            $subscription->subscription_type = "trial";
            $subscription->payment_date = Carbon::now();
            $subscription->save();
            $user->trial_used = true;
            $user->subscription_enabled = true;
            $user->save();
            return 'success';
        }
        else return "error";
    }

    public function getChannelUser($channel_id){
        $user = User::where('channel_id', $channel_id)->first();
        if(!empty($user)){
            $channel = Channel::find($user->channel_id);
            if(!empty($channel->channel_logo)) return $user->id;
            else return 0;
        }
        else return 0;
    }
}