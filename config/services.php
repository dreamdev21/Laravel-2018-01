<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'braintree' => [
        'model' => App\User::class, //model used to processs payments
        Braintree_Configuration::environment('production'),
        Braintree_Configuration::merchantId('c9br5f7skrtj4tz2'),
        Braintree_Configuration::publicKey('ctqq53hrpys5gxpy'),
        Braintree_Configuration::privateKey('0712849c4d177d33a97d50ab411f0b77'),
//        Braintree_Configuration::environment('sandbox'),
//        Braintree_Configuration::merchantId('sw5h9d9wptqb9thc'),
//        Braintree_Configuration::publicKey('t4mrkdybb8y28rcg'),
//        Braintree_Configuration::privateKey('e6ca1b25d68e1190a9e58bbd4125d5ff')
    ],

    'facebook' => [
        'client_id' => '1860774100918152', // configure with your app id
        'client_secret' => 'fed375773534a60ba695a761e2e92ba4', // your app secret
        'redirect' => 'https://entertale.com/fb_login/callback', // leave blank for now
    ],

];
