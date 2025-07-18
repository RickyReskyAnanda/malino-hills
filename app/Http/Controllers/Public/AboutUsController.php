<?php

namespace App\Http\Controllers\Public;

use App\Enums\ImageType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Image;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        return view('landing-page.about-us.index');
    }
}
