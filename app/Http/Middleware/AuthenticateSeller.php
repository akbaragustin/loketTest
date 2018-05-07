<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AuthenticateSeller
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

        if (!empty(\Session::get('auth'))) {
           return redirect('/');
        }
         return $next($request);
    }
}
