<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEmptyCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (count($user->CoursesInCart) == 0 && count($user->VideosInCart) == 0){
            return redirect('/');
        }
        return $next($request);
    }
}
