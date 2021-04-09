<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if (auth()->user()->is_active == 1  && auth()->user()->is_staff == 1 && auth()->user()->is_superuser == 1) {
            return $next($request);
        } else {
            return redirect('login')->with(['status' => 'Unauthorized']);
        }
    }
}
