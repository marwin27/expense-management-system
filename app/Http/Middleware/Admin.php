<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'Admin' role
        if (Auth::check() && Auth::user()->role === 'Admin') {
            return $next($request);
        }
else
        // Redirect to home or another page if not authorized
        return redirect('/dashboard'); // Or another route
    }
}
