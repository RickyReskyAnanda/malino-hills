<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Information;
use Illuminate\Support\Facades\View;

class LandingPageDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $data = Information::first(); // Misalkan Anda memiliki metode getFooterData() di model Informasi

        // Jika data footer tidak ada, bisa ditangani sesuai kebutuhan
        $landingPageData = $data ?: [
            'address' => env('DEFAULT_LANDING_PAGE_ADDRESS'),
            'email' => env('DEFAULT_LANDING_PAGE_EMAIL'),
            'youtube' => env('DEFAULT_LANDING_PAGE_YOUTUBE'),
            'facebook' => env('DEFAULT_LANDING_PAGE_FACEBOOK'),
            'instagram' => env('DEFAULT_LANDING_PAGE_INSTAGRAM'),
            'whatsapp' => env('DEFAULT_LANDING_PAGE_WHATSAPP'),
            'tiktok' => env('DEFAULT_LANDING_PAGE_TIKTOK'),
        ];

        // Share data footer dengan semua view
        View::share('landingPageData', $landingPageData);


        // Ambil locale dari parameter URL
        $locale = $request->route('locale');

        // Cek apakah locale valid
        if (in_array($locale, ['id', 'en'])) {
            // Simpan locale dalam cookie
            cookie()->queue('locale', $locale, 60 * 24 * 30); // Simpan selama 30 hari
            app()->setLocale($locale);
        } else {
            // Cek apakah cookie locale sudah ada
            $locale = $request->cookie('locale', 'en'); // Ganti 'en' dengan default Anda
            cookie()->queue('locale', $locale, 60 * 24 * 30); // Simpan selama 30 hari
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
