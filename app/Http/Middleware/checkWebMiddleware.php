<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkWebMiddleware {
    
    public function handle($request, Closure $next) {

        if (Auth::guard('web')->check()) {

        }else{
            return redirect()->route('home.index');;
        }

        return $next($request);
        
    }
}