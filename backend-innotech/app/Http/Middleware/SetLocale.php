<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $allowedLocales = config('app.available_locales', ['fr', 'en', 'ar']);

        $codeLang = $request->get('codeLang')
            ?? $request->header('Accept-Language')
            ?? config('app.locale', 'fr');

        $codeLang = Str::substr($codeLang, 0, 2);

        if (!in_array($codeLang, config('app.available_locales'))) {
            $codeLang = config('app.locale', 'fr');
        }

        App::setLocale($codeLang);

        return $next($request);
    }
}
