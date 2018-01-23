<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if(
            Auth::attempt([ 'email' => $request->email, 'password' => $request->password ]) ||
            Auth::attempt([ 'phone' => preg_replace( '/[^0-9]/', '', $request->email ), 'password' => $request->password ])
        )
        {
            $mytime = Carbon::now()->format('Y-m-d h:m:s');
            $user = Auth::user();
            $user->last_login = $mytime;
            $user->save();
            return redirect()->route('home'); }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
