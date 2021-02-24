<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfWebsiteAuthenticated
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
        //If request comes from logged in user, he will
       //be redirect to home page.
    //    if (auth()->guard()->check()) {
    //     return redirect('/canvas/dashboard');
    //     }

        //If request comes from logged in seller, he will
        //be redirected to seller's home page.
        if (auth()->guard('website')->check()) {
            return redirect('/canvas/dashboard');
        }
        return $next($request);
    
    }
}
