<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class CheckLangMiddleware {
    
    public function handle($request, Closure $next) {

        $setLang = $request->cookie('langvtgm');

        if((!empty($setLang))&&($setLang != '')) {
            App::setLocale($setLang);
            return $next($request);
        }else{
            $cookie = cookie('langvtgm', 'es', 60 * 2160);
            App::setLocale('es');
            return $next($request)->withCookie($cookie);
        }
        
    }
}