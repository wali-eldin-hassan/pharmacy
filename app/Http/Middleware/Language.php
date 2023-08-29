<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Language
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

        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                $language = \App\Settings::all()->last();
                if (is_null($language)) {
                    App::setLocale('en');
                    return $next($request);
                } else {
                    App::setLocale($language->language);
                    return $next($request);
                }
            }
        } catch (\Exception $e) {
            App::setLocale('en');
            return $next($request);
        }

    }
}
