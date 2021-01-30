<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class FieldMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('_fieldId'))
        {
            return $next($request);
        }
        return redirect()->route('admin.fields');
    }
}
