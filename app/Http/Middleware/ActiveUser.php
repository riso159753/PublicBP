<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActiveUser
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

        if (!Auth::check()) {
            return redirect()->route('login', app()->getLocale());
        }

        if (auth()->user()->deleted_at) {

            $user = auth()->user();
            auth()->logout();
            return redirect()->route('login', app()->getLocale());
        }
        return $next($request);
    }
}
