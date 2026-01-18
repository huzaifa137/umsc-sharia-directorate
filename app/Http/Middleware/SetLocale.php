<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Read the locale from the session (after StartSession middleware)
        $locale = $request->session()->get('locale', config('app.locale'));
        app()->setLocale($locale);

        return $next($request);
    }
}
