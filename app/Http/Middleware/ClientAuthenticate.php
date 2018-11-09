<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use DB;

class ClientAuthenticate
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
        if(!$request->session()->exists('client_data')) {
            return redirect('clienthub/login');
        }

        $client = $request->session()->get('client_data');
        $check = DB::table('clients_login')
                ->join('clients_contact','clients_contact.client_id','=','clients_login.client_id')
                ->where('type','2')
                ->where('value',$client['client_email'])
                ->first();
        if(empty($check)) {
            return redirect('clienthub/login');
        }

        return $next($request);
    }
}
