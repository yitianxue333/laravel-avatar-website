<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use DB;

class PermissionManager
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
        $permission = $request->session()->get('permission');
        if ($permission != '3' && $permission != '4' && $permission != '5') {
            return $next($request);
        } else {
            return response(view('error.403'));
        }
    }
}
