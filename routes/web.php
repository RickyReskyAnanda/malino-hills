<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use App\Http\Middleware\LandingPageDataMiddleware;
use App\Http\Middleware\LanguageMiddleware;


use App\Http\Controllers\Public\{
    HomeController,
    VillaController,
    FacilityController,
    GalleryController,
    MeetingController,
    ExperienceController,
    InformationController,
    AboutUsController,
    LocateUsController,
    ContactUsController,
    PrivacyPolicyController,
    CheckAvailabilityController,
    SheetController,
};

use App\Http\Controllers\Backoffice\AuthController;
use App\Http\Controllers\Backoffice\VillaController as BFVillaController;
use App\Http\Controllers\Backoffice\VillaGalleryController as BFVillaGalleryController;
use App\Http\Controllers\Backoffice\VillaFacilityController as BFVillaFacilityController;
use App\Http\Controllers\Backoffice\VillaHighlightFacilityController as BFVillaHighlightFacilityController;

use App\Http\Controllers\Backoffice\GalleryController as BFGalleryController;
use App\Http\Controllers\Backoffice\FacilityController as BFFacilityController;
use App\Http\Controllers\Backoffice\ExperienceController as BFExperienceController;
use App\Http\Controllers\Backoffice\BookingController as BFBookingController;
use App\Http\Controllers\Backoffice\InformationContactController as BFInformationContactController;
use App\Http\Controllers\Backoffice\InformationLocationController as BFInformationLocationController;
use App\Http\Controllers\Backoffice\InformationSocMedController as BFInformationSocMedController;
use App\Http\Controllers\Backoffice\MeetingRoomController as BFMeetingRoomController;
use App\Http\Controllers\Backoffice\MeetingRoomGalleryController as BFMeetingRoomGalleryController;
use Illuminate\Http\Request;



Route::middleware([OnlyGuestMiddleware::class])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');
});

Route::middleware([OnlyMemberMiddleware::class])->group(function () {
    Route::get('app/{any?}', function(){
        return view('backoffice.app');
    })->where('any', '.*');
    Route::get('logout', [AuthController::class, 'doLogout'])->name('logout');

    Route::prefix("api")->group(function () {
        Route::get('villa', [BFVillaController::class,'index']);
        Route::get('villa/{id}', [BFVillaController::class,'show']);
        Route::post('villa', [BFVillaController::class,'store']);
        Route::put('villa/{id}', [BFVillaController::class,'update']);

        Route::get('villa/{id}/gallery', [BFVillaGalleryController::class,'index']);
        Route::post('villa/{id}/gallery', [BFVillaGalleryController::class,'store']);
        Route::delete('villa/{id}/gallery/{idImage}', [BFVillaGalleryController::class,'destroy']);

        Route::get('villa/{id}/facility', [BFVillaFacilityController::class,'index']);
        Route::put('villa/{id}/facility', [BFVillaFacilityController::class,'update']);
        Route::delete('villa/{id}/facility/{idFacility}', [BFVillaFacilityController::class,'destroy']);

        Route::get('villa/{id}/highlight-facility', [BFVillaHighlightFacilityController::class,'index']);
        Route::put('villa/{id}/highlight-facility', [BFVillaHighlightFacilityController::class,'update']);

        
        Route::get('gallery', [BFGalleryController::class,'index']);
        Route::post('gallery', [BFGalleryController::class,'store']);
        Route::delete('gallery/{id}', [BFGalleryController::class,'destroy']);

        Route::get('facility', [BFFacilityController::class,'index']);
        Route::get('facility/{id}', [BFFacilityController::class,'show']);
        Route::post('facility', [BFFacilityController::class,'store']);
        Route::put('facility/{id}', [BFFacilityController::class,'update']);
        Route::delete('facility/{id}', [BFFacilityController::class,'destroy']);

        Route::get('experience', [BFExperienceController::class,'index']);
        Route::get('experience/{id}', [BFExperienceController::class,'show']);
        Route::post('experience', [BFExperienceController::class,'store']);
        Route::put('experience/{id}', [BFExperienceController::class,'update']);
        Route::delete('experience/{id}', [BFExperienceController::class,'destroy']);

        Route::get('booking', [BFBookingController::class,'index']);
        Route::patch('booking', [BFBookingController::class,'update']);
        Route::get('booking/select/villa', [BFBookingController::class,'getVilla']);

        Route::post('booking-bulk', [BFBookingController::class,'storeBulk']);

        // Route::get('create-sheet', [SheetController::class,'createSheet']);
        // Route::get('setup-sheet', [SheetController::class,'setUpSheet']);
        // Route::get('booking-sheet', [SheetController::class,'setBookingDate']);


        Route::get('info-contact', [BFInformationContactController::class,'index']);
        Route::patch('info-contact', [BFInformationContactController::class,'update']);

        Route::get('info-location', [BFInformationLocationController::class,'index']);
        Route::patch('info-location', [BFInformationLocationController::class,'update']);

        Route::get('info-socmed', [BFInformationSocMedController::class,'index']);
        Route::patch('info-socmed', [BFInformationSocMedController::class,'update']);

        Route::get('meeting-room', [BFMeetingRoomController::class,'index']);
        Route::patch('meeting-room', [BFMeetingRoomController::class,'update']);

        Route::get('meeting-room/gallery', [BFMeetingRoomGalleryController::class,'index']);
        Route::post('meeting-room/gallery', [BFMeetingRoomGalleryController::class,'store']);
        Route::delete('meeting-room/gallery/{idImage}', [BFMeetingRoomGalleryController::class,'destroy']);
        
    });
});


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return response()->json(['message' => 'All caches cleared successfully.']);
});
Route::get('/developer', function() {

     return redirect()->away('https://ricky-resky-ananda.netlify.app');
});


Route::get('/', function (Request $request) {
    $locale = $request->cookie('locale', 'en'); // Ganti 'id' dengan default Anda
    return redirect('/' . $locale);
});
Route::middleware([LandingPageDataMiddleware::class, LanguageMiddleware::class])->prefix('id')->group(function () {
    Route::get('/', [HomeController::class,'index']);
    Route::get('villas', [VillaController::class,'index']);
    Route::get('villas/{id}/{name}', [VillaController::class,'show']);
    Route::get('facilities', [FacilityController::class,'index']);
    Route::get('gallery', [GalleryController::class,'index']);
    Route::get('meeting', [MeetingController::class,'index']);
    Route::get('experience', [ExperienceController::class,'index']);
    Route::get('experience/{id}/{name}', [ExperienceController::class,'show']);
    Route::get('about-us', [AboutUsController::class,'index']);
    Route::get('locate-contact', [LocateUsController::class,'index']);
    Route::get('privacy-policy', [PrivacyPolicyController::class,'index']);
    Route::get('check-availability', [CheckAvailabilityController::class,'index']);
    Route::get('check-availability/availability', [CheckAvailabilityController::class,'availability']);
    Route::get('check-availability/checking', [CheckAvailabilityController::class,'checking']);
    Route::get('check-availability/checking-by-search', [CheckAvailabilityController::class,'checkingBySearch']);
});
Route::middleware([LandingPageDataMiddleware::class, LanguageMiddleware::class])->prefix('en')->group(function () {
    Route::get('/', [HomeController::class,'index']);
    Route::get('villas', [VillaController::class,'index']);
    Route::get('villas/{id}/{name}', [VillaController::class,'show']);
    Route::get('facilities', [FacilityController::class,'index']);
    Route::get('gallery', [GalleryController::class,'index']);
    Route::get('meeting', [MeetingController::class,'index']);
    Route::get('experience', [ExperienceController::class,'index']);
    Route::get('experience/{id}/{name}', [ExperienceController::class,'show']);
    Route::get('about-us', [AboutUsController::class,'index']);
    Route::get('locate-contact', [LocateUsController::class,'index']);
    Route::get('privacy-policy', [PrivacyPolicyController::class,'index']);
    Route::get('check-availability', [CheckAvailabilityController::class,'index']);
    Route::get('check-availability/availability', [CheckAvailabilityController::class,'availability']);
    Route::get('check-availability/checking', [CheckAvailabilityController::class,'checking']);
    Route::get('check-availability/checking-by-search', [CheckAvailabilityController::class,'checkingBySearch']);
});

