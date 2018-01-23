<?php

namespace App\Http\Controllers\Auth;

use App\EmailSettings;
use App\User;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

use MetaTag;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'username' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|bool'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if($data['gender'])
        {
             $avatar = 'male.jpg';
        }
        else
        {
            $avatar = 'female.png';
        }

        $ipaddress = $_SERVER['REMOTE_ADDR'];

        if($ipaddress == '127.0.0.1'){

//            $ipaddress = '95.140.192.60';
            $ipaddress = '41.63.191.255';

        }

        $my_ip = file_get_contents('http://freegeoip.net/json/' . $ipaddress);
        $latitude_by_ip = json_decode($my_ip,true)['latitude'];
        $longitude_by_ip = json_decode($my_ip,true)['longitude'];
        $country_code_by_ip = json_decode($my_ip,true)['country_code'];
        $country_name_by_ip = json_decode($my_ip,true)['country_name'];



        $reg_res = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'gender'   => $data['gender'],
            'password' => bcrypt($data['password']),
            'slug'     => str_slug($data['name']),
            'avatar'   => $avatar,
            'role'     => 3,
            'ip'       => $ipaddress,
            'lat'      => $latitude_by_ip,
            'lng'      => $longitude_by_ip,
            'country'  => $country_name_by_ip,
            'country_code'  => $country_code_by_ip
        ]);

        if($reg_res){
            auth()->login($reg_res);
            $emailtext['name'] = $data['name'];
            $emailtext['username'] = $data['username'];
            $emailtext['email'] = $data['email'];
            $usemail = $emailtext['email'];

            Mail::send('emails.reg', ['name' => $emailtext['name'], 'username' => $emailtext['username'], 'email' => $emailtext['email']], function ($message) use ($usemail) {
                $message->to($usemail)
                    ->subject('Registration');
            });
        }

        return $reg_res;
    }


    
    
}
