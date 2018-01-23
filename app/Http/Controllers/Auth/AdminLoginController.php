<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin');

    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        //attempt to login

        if (Auth::guard('admin')->attempt([
            'email' => trim($request->email),
            'password' => trim($request->password)
        ],
            $request->remember)  ){

            return redirect()->intended(route('admin.dashboard'));

        }

        //if admin login is unsuccessful
        return redirect()->back()->withInput($request->only('email', 'remember'));

    }


}
