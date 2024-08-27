<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('appName', 'Malino Hills');
        View::share('rooms',[
            [ 'link' => asset('assets/images/room/1.avif'), 'name'=>'Villa Tulip'],
            [ 'link' => asset('assets/images/room/2.avif'), 'name'=>'Villa Orchid'],
            [ 'link' => asset('assets/images/room/3.avif'), 'name'=>'Villa Lotus'],
        ]);
    }
}
