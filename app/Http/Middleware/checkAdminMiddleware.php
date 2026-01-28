<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class checkAdminMiddleware {
    
    public function handle($request, Closure $next) {

        $availables = ['wpanel', 'wpanel/forgot'];
        $routename = Route::current();

        if (Auth::guard('admin')->check()) {
            if(in_array($routename->uri, $availables)) {
                return redirect('/wpanel/home');    
            }
        }else{
            if(!in_array($routename->uri, $availables)) {
                return redirect('/wpanel');
            }
        }

        return $next($request);
        
    }
}