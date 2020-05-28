<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::user() &&  Auth::user()->isAdmin()) {
//            Auth::user()->updateLastOnline();
            return $next($request);
        }
        return redirect()->route('cabinet.main')->with(['danger' => 'У вас нету прав доступа в эту часть кабинета!']);
    }
}