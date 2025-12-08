<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'pt';

        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } elseif ($request->cookie('crow_locale')) {
            $locale = $request->cookie('crow_locale');
        }

        if (! in_array($locale, ['en', 'pt'])) {
            $locale = 'pt';
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}