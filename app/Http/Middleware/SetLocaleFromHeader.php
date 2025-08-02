<?php

namespace App\Http\Middleware;

use Closure;

class SetLocaleFromHeader
{
    public function handle($request, Closure $next)
    {
        $lang = $request->header('Accept-Language');
        $supported = ['en','ar','fr','tr','ru'];
        if ($lang && in_array($lang, $supported)) {
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
