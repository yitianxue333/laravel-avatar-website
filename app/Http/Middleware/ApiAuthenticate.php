<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = ($request->headers->all());

        if(!isset($headers['access-token'])):
            echo json_encode(array(
                'success' => false,
                'errorMessage' => 'Unauthorized Request.'
            ));

            exit;
        endif;
        
        $user = User::where('api_token', $headers['access-token'][0])->first();
        if(empty($user)) :
            echo json_encode(array(
                'success' => false,
                'errorMessage' => 'Access token is invalid.'
            ));

            exit;
        endif;

        return $next($request);
    }
}
