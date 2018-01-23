<?php namespace App\Services\Billing;

use Braintree_Configuration;
use Braintree_PaymentMethodNonce;
use App\User;
use Braintree_Customer;
use Exception;
use Braintree_Subscription;
use Braintree_Transaction;


class Billing {

    public function __construct()
    {
        Braintree_Configuration::environment(env('BRAINTREE_ENVIRONMENT'));
        Braintree_Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Braintree_Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
        Braintree_Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));
    }

    /**
     * Add the credit card that the user has provided to the vault
     *
     * @param  int  $tid
     * @param  array  $input
     **/


    public function ppv( $tid, $input )
    {
        $transaction = \UserCreation::findByTransactionIdOrFail($tid);

        $user = User::find($transaction->user_id);

        if($input['payment_type']=='CreditCard'){
            $payment_type='creditcard';
        }elseif($input['payment_type']=='PayPalAccount'){
            $payment_type='paypal';
        }else{
            throw new Exception('Wrong!');
        }

        // Create Customer on braintree
        $result = Braintree_Customer::create([
            'firstName' => $user->username,
            'email' => $user->email,
            'paymentMethodNonce' => $input['payment_method_nonce'],
        ]);

        if($result->success){

            //Create Subscription
            $customer = Braintree_Customer::find($result->customer->id);

            // Update user things
            if($payment_type=='creditcard'){
                $user->card_last_four = $customer->creditCards[0]->last4;
                $user->card_brand = $customer->creditCards[0]->cardType;
            }

            // Update user things
            $user->braintree_id = $result->customer->id;
            $user->braintree_type = $payment_type;
            $user->subscription_type = 'ppv';
            $user->active = true;
            $user->save();

            // Update Transaction
            $transaction->state = true;
            $transaction->save();

            return $user;

        }else{
            throw new BillingException($result->message);
        }

    }

    /**
     * Vault a paypal account
     *
     * @param $nonce
     * @param User $user
     * @throws Exception
     * @internal param int $tid
     * @internal param array $input
     * @return int vaultedCard
     */

    private function vaultPayPal($nonce,$tid){

        $transaction = \UserCreation::findByTransactionIdOrFail($tid);

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

    /**
     * Vault a credit card account
     *
     * @param $nonce
     * @param User $user
     * @throws Exception
     * @internal param int $tid
     * @internal param array $input
     * @return int vaultedCard
     */
    private function vaultCreditCard($nonce,$tid){

    }

    public function subscribeToPlan(User $user){

        //Find Customer
        $customer = Braintree_Customer::find($user->braintree_id);

        if($user->braintree_type=='creditcard'){
            $paymentToken = $customer->creditCards[0]->token;
        }else{
            // paypal
            $paymentToken = $customer->paypalAccounts[0]->token;
        }

        //Create Subscription
        $subscription = Braintree_Subscription::create(array(
            'paymentMethodToken' => $paymentToken,
            'planId' => env('BRAINTREE_PLAN_ID')
        ));

        //Save Plan Info to User
        $user->braintree_subscription_id = $subscription->subscription->id;
        $user->braintree_plan = $subscription->subscription->planId;
        $user->subscription_type='subscription';
        $user->save();

    }

    public function rentTitle(User $whoPays,User $whoReceives ,$title){

        $result = Braintree_Transaction::sale(
            [
                'customerId' => $whoPays->braintree_id,
                'amount' => $title->cost,
                'options' => [
                    'submitForSettlement' => True
                ]
            ]
        );

        if($result->success){

            $lastUntil = \Carbon\Carbon::now()->addHours($title->period);

            if($title->type=='video'){

                $buy=\UserBuy::create([
                    'user_id' => $whoReceives->id,
                    'title_id' => $title->title_id,
                    'valid_until' => $lastUntil,
                    'amount' => $title->cost
                ]);

            }elseif($title->type=='season'){

                $buy=\UserBuy::create([
                    'user_id' => $whoReceives->id,
                    'title_id' => $title->title_id,
                    'season_id' => $title->season_id,
                    'valid_until' => $lastUntil,
                    'amount' => $title->cost
                ]);

            }else{

                $buy=\UserBuy::create([
                    'user_id' => $whoReceives->id,
                    'title_id' => $title->title_id,
                    'season_id' => $title->season_id,
                    'episode_id' => $title->episode_id,
                    'valid_until' => $lastUntil,
                    'amount' => $title->cost
                ]);

            }

            if($whoPays->uuid!=$whoReceives->uuid){
                $buy->paid_by=$whoPays->id;
                $buy->save();

                $event = \UserEvent::create([
                    'user_id'=>$whoReceives->id,
                    'available' => true,
                    'uuid' => \Webpatser\Uuid\Uuid::generate(4)->string,
                    'private' => true,
                    'likes' => 0
                ]);

                $buy->event()->save($event);

                event(New \App\Events\RentForFriend($whoReceives,$buy));
            }

        }else{
            throw new Exception($result->message);
        }

    }

}
