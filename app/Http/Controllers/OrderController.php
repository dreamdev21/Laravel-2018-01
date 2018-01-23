<?php

namespace App\Http\Controllers;


use App\Movie;
use App\UserCreation;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Braintree_Configuration;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Payment;
use Braintree_Transaction;
use Braintree_PaymentMethod;
use Braintree_Customer;
use App\Services\Exceptions\BillingException;
use Braintree_PaymentMethodNonce;
use App\Http\Requests;
use App\Follow;




class OrderController extends Controller
{


    public  function _construct(){

        $this->middleware('auth');

        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('sw5h9d9wptqb9thc');
        Braintree_Configuration::publicKey('t4mrkdybb8y28rcg');
        Braintree_Configuration::privateKey('e6ca1b25d68e1190a9e58bbd4125d5ff');

    }



    public function rentModal(Movie $movie){

        $user = Auth::user();


       if (!Auth::user()) {
           return redirect('/login')->with('error', 'You need to register');
        }

        $userId = $user->id;

        return view('modals.rent', compact( 'userId', 'movie'));

    }

    public function processRent(Request $request, Movie $movie)
    {

        $amount  = $request['amount'];
        $paymentMethodNonce   = $request['payment_method_nonce'];
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
            $all_f_list = $this->chat_res();
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $mov_name = Movie::select('title')->where('id', $request->cd__36698__1WWWm)->first();
            $payment = new Payment;
            $payment->user_id = Auth::id();
            $payment->transaction_id = $result->transaction->id;
            if(isset($request->cd__36698__1WWWm)){
                $payment->movie_id = $request->cd__36698__1WWWm;
            }
            if(isset($request->cd__36725__1WWWm)){
                $payment->series_id = $request->cd__36725__1WWWm;
            }
            if(isset($request->cd__39165__1WWWm)){
                $payment->series_id = $request->cd__39165__1WWWm;
            }
            $payment->amount = $result->transaction->amount;
            $payment->save();


            if(isset($request->cd__36698__1WWWm)){

                $url = env('APP_URL').':3000/rent';
                $data = array(
                    'event' => 'rent',
                    'r_user_id' => Auth::id(),
                    'r_user_avatar' => Auth::user()->avatar,
                    'r_user_username' => Auth::user()->username,
                    'r_user_fr' => $all_f,
                    'r_movie_id' => $request->cd__36698__1WWWm,
                    'r_movie_title' => $mov_name->title,
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

            }

            return back();

        }else{

            return back();

        }


    }


    public function processSavePayRent(Request $request, Movie $movie)
    {

        $amount  = $request['amount'];

        $result = Braintree_Transaction::sale([
            'amount' => $amount,
            'customerId' => Auth::user()->braintree_id,
            'paymentMethodToken' =>  Auth::user()->braintree_token,
            'options' => [
                'submitForSettlement' => True,
                'storeInVaultOnSuccess' => True
            ]
        ]);

        if ($result->success) {
            $all_f_list = $this->chat_res();
            $all_f = [];
            foreach ($all_f_list as $val){
                $all_f[] = $val->id;
            }
            $all_f = implode(",", $all_f);

            $payment = new Payment;
            $payment->user_id = Auth::id();
            $payment->transaction_id = $result->transaction->id;

            if(isset($request->cd__36698__1WWWm)){
                $mov_name = Movie::select('title')->where('id', $request->cd__36698__1WWWm)->first();
                $payment->movie_id = $request->cd__36698__1WWWm;
            }
            if(isset($request->cd__36725__1WWWm)){
                $payment->series_id = $request->cd__36725__1WWWm;
            }
            if(isset($request->cd__39165__1WWWm)){
                $payment->season_id = $request->cd__39165__1WWWm;
            }

            $payment->amount = $result->transaction->amount;
            $payment->save();


            if(isset($request->cd__36698__1WWWm)) {
                $url = env('APP_URL') . ':3000/rent';
                $data = array(
                    'event'           => 'rent',
                    'r_user_id'       => Auth::id(),
                    'r_user_avatar'   => Auth::user()->avatar,
                    'r_user_username' => Auth::user()->username,
                    'r_user_fr'       => $all_f,
                    'r_movie_id'      => $request->cd__36698__1WWWm,
                    'r_movie_title'   => $mov_name->title,
                );

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context = stream_context_create($options);
                file_get_contents($url, false, $context);
            }


            return back();

        }else{

            return back();

        }

    }



    public function store(Request $request)
    {



    }


    private function vaultPayPal($nonce, $tid){

        $transaction = UserCreation::findByTransactionIdOrFail($tid);

        $user = User::find($transaction->id);

        // Create Customer on paypal
        $result = Braintree_Customer::create([
            'firstName' => $user->username,
            'email' => $user->email,
            'paymentMethodNonce' => $nonce,
        ]);

        if($result->success){

            $customer = Braintree_Customer::find($result->customer->id);

            $transaction->state = true;
            $transaction->save();

            $user->braintree_id = $customer->id;
            $user->braintree_type = 'paypal';
            $user->active = true;
            $user->save();

            Auth::loginUsingId($user->id);

        }else{
            throw new BillingException($result->message);
        }

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



}
