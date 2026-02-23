<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        if (in_array($locale, ['es', 'en', 'fr'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        } elseif ($request->query('lang') && in_array($request->query('lang'), ['es', 'en', 'fr'])) {
            app()->setLocale($request->query('lang'));
            session(['locale' => $request->query('lang')]);
        } elseif (session('locale') && in_array(session('locale'), ['es', 'en', 'fr'])) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
