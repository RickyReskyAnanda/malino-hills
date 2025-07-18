<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Mengambil segmen pertama dari URL
        $lang = $request->segment(1);

        // Daftar bahasa yang diizinkan
        $availableLanguages = ['en', 'id'];

        // Memeriksa apakah bahasa yang diminta tersedia
        if (in_array($lang, $availableLanguages)) {
            App::setLocale($lang);
        } else {
            // Jika tidak valid, bisa di-set ke default (misalnya 'en')
            App::setLocale('en');
        }

        return $next($request);
    }
}
