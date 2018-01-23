<?php
/**
 * Created by PhpStorm.
 * User: WFMarket2
 * Date: 12.07.2017
 * Time: 18:01
 */

namespace App\Http\Controllers;

use App\Payment;
use App\Subscription;
use Braintree_Customer;
use Braintree_PaymentMethod;
use Braintree_Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Advertising;
use App\Videos;
use App\Channel;
use JmesPath\Env;
use Session;
use File;
use App\BannerAdvertising;


class AdvertisingTvController extends Controller
{
    public function index()
    {
        $bannre_ads = BannerAdvertising::where('id', 1)->first();
        $bannre_ads_news1 = BannerAdvertising::where('id', 2)->first();
        $bannre_ads_left = BannerAdvertising::where('id', 3)->first();
        $bannre_ads_left2 = BannerAdvertising::where('id', 4)->first();
        $ads = Advertising::where('user_id', Auth::id())->get();
        return view('tvstation.advertising.index', compact('ads'));
    }

    public function create()
    {
        return view('tvstation.advertising.create');
    }

    public function store(Request $request)
    {
        set_time_limit(-1);
        $this->validate($request, array(
            'preroll_name'       => 'required',
            'preroll_goto_link'  => 'required',
            'preroll_skip_timer' => 'required',
            'thumb_img'          => 'required',
        ));
        if(!$request->has('payment_method_nonce')) return redirect()->back();
        $advertising = new Advertising;
        $advertising->user_id = Auth::id();
        $advertising->preroll_name = $request->preroll_name;
        $advertising->preroll_type = 'preroll';
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
        else return redirect()->back();
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
        if($request->has('url')) $advertising->url = $request->input('url');
        $advertising->save();
        $amount  = $request->input('amount');
        $paymentMethodNonce   = $request->input('payment_method_nonce');
        $result = '';
        if($request->save == 'on'){
            $crate_c_result = Braintree_Customer::create([
                'firstName' => Auth::user()->username,
                'email' => Auth::user()->email,
            ]);
            if($crate_c_result->success){
                $create_pm_result = Braintree_PaymentMethod::create(
                    [
                        'paymentMethodNonce' => $paymentMethodNonce,
                        'customerId' => $crate_c_result->customer->id,
                        'options' => ['verifyCard' => true]
                    ]
                );
                $newPaymentMethodToken = $create_pm_result->paymentMethod->token;
                $result = Braintree_Transaction::sale(
                    [
                        'amount' => $amount,
                        'paymentMethodToken' => $newPaymentMethodToken,
                        'options' => [
                            'submitForSettlement' => True,
                            'storeInVaultOnSuccess' => True
                        ]
                    ]
                );
                $last4 = $create_pm_result->paymentMethod->last4;
                $braintree_id = $create_pm_result->paymentMethod->customerId;
                $user = Auth::user();
                $user->braintree_id = $braintree_id;
                $user->card_last_four = $last4;
                $user->braintree_token = $newPaymentMethodToken;
                $user->save();
            }
        }
        else{
            $result = Braintree_Transaction::sale(
                [
                    'amount' => $amount,
                    'paymentMethodNonce' => $paymentMethodNonce,
                    'options' => [
                        'submitForSettlement' => True,
                        'storeInVaultOnSuccess' => True
                    ]
                ]
            );
        }
        if ($result->success) {
            $payment = new Payment;
            $payment->user_id = Auth::id();
            $payment->transaction_id = $result->transaction->id;
            $payment->adv_id = $advertising->id;
            $payment->amount = $result->transaction->amount;
            $payment->save();
            $this->setAdvertisingDate($advertising->id, $payment->amount);
        }
        Session::flash('success', 'The new Advertising was successfully added!');
        return redirect()->route('advertising.index');
    }

    public function setAdvertisingDate($id, $amount){
        $adv = Advertising::find($id);
        $amount = intval($amount);
        $date = Carbon::now();
        switch ($amount){
            case 100:
                $date = $date->addWeek();
                break;
            case 200:
                $date = $date->addWeeks(2);
                break;
            case 1000:
                $date = $date->addMonth();
                break;
            case 2000:
                $date = $date->addMonths(3);
                break;
        }
        $adv->expiration_date = $date;
        $adv->save();
    }

    public function create_body()
    {
        $subscription = Subscription::where('user_id', Auth::user()->id)->orderBy('id','desc')->first()->subscription_type;
        return view('tv.create-adv-modal', compact('subscription'));
    }

    public function edit_body($id){
        $ads = Advertising::find($id);
        return view('tv.edit-adv-modal', compact('ads'));
    }

    public function remove_body($id){
        $ads = Advertising::find($id);
        return view('tv.remove-adv-modal', compact('ads'));
    }

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
        return redirect()->back();
    }
}