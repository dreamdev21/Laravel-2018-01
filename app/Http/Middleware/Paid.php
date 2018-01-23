<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use Illuminate\Support\Facades\Redirect;







class Paid
{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }


    private function paid($request, $movie, $user)
    {


    }

}