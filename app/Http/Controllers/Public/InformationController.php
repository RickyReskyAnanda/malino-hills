<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
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

    public function experience(){
        return view('landing-page.experience.index');
    }
    public function experienceDetail(){
        return view('landing-page.experience.detail.index');
    }
    public function facilities(){
        return view('landing-page.facilities.index');
    }
    public function reservation(){
        return view('landing-page.reservation.index');
    }
}
