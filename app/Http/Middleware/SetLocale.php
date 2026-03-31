<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = collect(glob(lang_path('*'), GLOB_ONLYDIR))
            ->map(fn (string $path) => basename($path))
            ->filter()
            ->values();

        $requestedLocale = $request->get('locale')
            ?? $request->header('X-Locale')
            ?? $request->getPreferredLanguage($availableLocales->all())
            ?? config('app.locale');

        App::setLocale(
            $availableLocales->contains($requestedLocale)
                ? $requestedLocale
                : config('app.locale', 'ar')
        );

        return $next($request);
    }
}
