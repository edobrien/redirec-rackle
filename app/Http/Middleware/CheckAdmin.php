<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class CheckAdmin
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
        if (auth()->user()->is_admin == User::FLAG_NO) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
