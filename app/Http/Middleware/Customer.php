<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user())
        {
            auth()->logout();
            return redirect()->route('login', app()->getLocale());
        }
        if (auth()->user()->role == "customer") {
            return $next($request);
        }else
        {
            return redirect()->back();

            auth()->logout();
            return redirect()->route('login', app()->getLocale())->with('error','You do not have rights to log in there.');
        }
    }
}
