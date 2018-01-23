<?php
/**
 * Created by PhpStorm.
 * User: WFMarket2
 * Date: 28.06.2017
 * Time: 15:40
 */

namespace App\Http\Middleware;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class TokenApi
{
    public function handle($request, Closure $next)
    {

        $token_custom = $request->token_custom;
        $user  = User::where('api_token', $token_custom)->first();
        if($user == null){

            $data['status'] = false;
            $data['message'] = 'invalid token';
            echo json_encode($data);
            die;
        }
        else{
            return $next($request);
        }

    }

}
