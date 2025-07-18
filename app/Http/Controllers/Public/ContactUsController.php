<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function index(){
        return view('landing-page.contact-us.index');
    }
}
