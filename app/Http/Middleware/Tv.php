<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use Illuminate\Support\Facades\Redirect;


class Tv
{

    public function handle($request, Closure $next)
    {

        if(Auth::check()) {
            if (Auth::user()->role == 4) {
                if(!Auth::user()->subscription_enabled) return redirect('make_subscription');
                return $next($request);
            }
        }
        return redirect('home');
    }


}