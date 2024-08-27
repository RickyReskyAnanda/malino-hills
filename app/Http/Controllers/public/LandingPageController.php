<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function home(){
        return view('landing-page.home.index');
    }

    public function rooms(){
        return view('landing-page.rooms.index');
    }
    public function roomDetail(){
        return view('landing-page.rooms.detail.index');
    }

    public function offers(){
        return view('landing-page.offers.index');
    }
    public function offerDetail(){
        return view('landing-page.offers.detail.index');
    }
    public function facilities(){
        return view('landing-page.facilities.index');
    }
    public function aboutUs(){
        return view('landing-page.about.index');
    }
    public function reservation(){
        return view('landing-page.reservation.index');
    }
}
