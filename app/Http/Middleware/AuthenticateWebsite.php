<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthenticateWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //If request does not comes from logged in seller
          //then he shall be redirected to Seller Login page
        if (! auth()->guard('website')->check()) {
            // return route('canvas.login');
            return Redirect::route('canvas.login');
        }

        return $next($request);
    }
}
