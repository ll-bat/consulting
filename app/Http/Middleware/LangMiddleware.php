<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return void
     */
    public function handle($request, Closure $next)
    {
        $lang = Cookie::get('lang', 'geo');
        App::setLocale($lang);
        return $next($request);
    }
}
