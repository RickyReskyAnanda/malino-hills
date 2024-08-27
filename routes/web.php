<?php

use App\Http\Controllers\public\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class,'home']);
Route::get('rooms', [LandingPageController::class,'rooms']);
Route::get('rooms/{name}', [LandingPageController::class,'roomDetail']);
Route::get('offers', [LandingPageController::class,'offers']);
Route::get('offers/{name}', [LandingPageController::class,'offerDetail']);
Route::get('facilities', [LandingPageController::class,'facilities']);
Route::get('about-malino-hills', [LandingPageController::class,'aboutUs']);
Route::get('reservation', [LandingPageController::class,'reservation']);


Route::get('office', function(){
    return view('backoffice.app');
});
