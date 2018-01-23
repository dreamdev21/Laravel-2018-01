<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use Illuminate\Support\Facades\Redirect;


class ElStudio
{

    public function handle($request, Closure $next)
    {

        if(Auth::check()) {

            if (Auth::user()->role != 2 && Auth::user()->role != 4) {
                return $next($request);
            }

        }
        if (Auth::user()->role == 4) {
            return redirect('/tv/videos');
        }
        return redirect('/studio/movies');
    }

}