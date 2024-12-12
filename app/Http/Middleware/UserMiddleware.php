<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user authenticated
        if(!Auth::check()){
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if($userRole == 1){
            return $next($request);
        }

        if($userRole == 2){
            return redirect()->route('home');
        }
    }
}
