<?php

namespace App\Http\Controllers;

use App\PaymentRequest;
use Illuminate\Http\Request;
use App\Studio;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use App\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class StudioSettingsController extends Controller
{
    public function index()
    {
        $studio = Studio::where('id', Auth::user()->studio_id)->first();

        $movie = Movie::orderBy('created_at', 'DESC')->where('studio_id', Auth::user()->studio_id)->get();
        $calcres = 0;
        foreach ($movie as $val){
            $calcpay = Payment::where('movie_id', $val->id)->orwhere('season_id', $val->season_id)->orwhere('series_id', $val->series_id)->get();
            foreach ($calcpay as $cp){
                $calcres = $calcres + $cp->amount;
            }

        }

        $calcres = $calcres/100*$studio->percent;

        $payreq = PaymentRequest::where('studio_id', Auth::user()->studio_id)->get();

        $a = $calcres;
        $b = $payreq->sum('amount');

        $a /= 100;
        $b /= 100;

        $calcres = (($a - $b)*100);
        $calcres = number_format($calcres, (19.2));
        $calcres = explode('.', $calcres);
        $calcres = $calcres[0].".".substr($calcres[1], 0, 2);

        $payreqres = PaymentRequest::where('studio_id', Auth::user()->studio_id)->get();

        return view('admin.users.studioSettings', compact('studio', 'calcres', 'payreqres'));
    }

    public function addemail(Request $request)
    {

        $this->validate($request, array(
            'email' => 'required|email|max:255',
        ));

        $email = $request->email;
        $studio = Studio::where('id', Auth::user()->studio_id)->first();
        $studio->paypal_email = $email;
        $studio->save();
        return redirect()->back();
    }

    public static function check_pp_email()
    {
        $studio_pp_email = Studio::where('id', Auth::user()->studio_id)->select('paypal_email')->first();
        return !empty($studio_pp_email->paypal_email);
    }

    public function paymentRequest()
    {
        $studio = Studio::where('id', Auth::user()->studio_id)->first();

        $movie = Movie::orderBy('created_at', 'DESC')->where('studio_id', Auth::user()->studio_id)->get();
        $calcres = 0;
        foreach ($movie as $val){
            $calcpay = Payment::where('movie_id', $val->id)->orwhere('season_id', $val->season_id)->orwhere('series_id', $val->series_id)->get();
            foreach ($calcpay as $cp){
                $calcres = $calcres + $cp->amount;
            }

        }
        $calcres = $calcres/100*$studio->percent;

        $payreq = PaymentRequest::where('studio_id', Auth::user()->studio_id)->get();

        $a = $calcres;
        $b = $payreq->sum('amount');

        $a /= 100;
        $b /= 100;

        $calcres = (($a - $b)*100);
        $calcres = number_format($calcres, (19.2));
        $calcres = explode('.', $calcres);
        $calcres = $calcres[0].".".substr($calcres[1], 0, 2);

        if($studio->paypal_email == null){
            Session::flash('error', 'Please enter your paypal email before payment request');
            return redirect()->back();
        }

        if($calcres < 50){
            Session::flash('error', 'Minimum withdrawal amount $50');
        }
        else{
            $pay_req = new PaymentRequest;
            $pay_req->studio_id = Auth::user()->studio_id;
            $pay_req->user_id = Auth::user()->id;
            $pay_req->amount = $calcres;
            $pay_req->status = 1;
            $pay_req->save();

            $usemail = 'talehouse@entertale.com';


            Mail::send('emails.preq', ['studioname' => $studio->name, 'email' => $studio->paypal_email, 'amount' => $calcres], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Payment Request');
            });

            Session::flash('success', 'Your payment request successfully sent');

        }

        return redirect()->back();
    }

}
