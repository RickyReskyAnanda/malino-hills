<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(){
        $data = Venue::with('slideImages')->where('id_venue',1)->first();
        return view('landing-page.meeting.index', compact('data'));
    }
}