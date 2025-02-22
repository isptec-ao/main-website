<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $lang = 'pt')
    {
        if(session()->has('locale')) {
            //
            app()->setLocale(session()->get('locale'));
        }
        if($request->lang) {
            //
            session()->put('locale', $request->lang);
        }

        if(!session()->has('locale') && !$request->lang) {
            session()->put('locale', $lang);
        }
        // (in_array($lang, config('app.locales')) ? app()->setLocale($lang) : app()->setLocale('pt'));

        return $next($request);
    }
}
