<?php

namespace App\Http\Controllers\Public;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(){

        $facilities = Facility::where('status',StatusType::PUBLISHED)
            ->inRandomOrder()
            ->get();
        
        return view('landing-page.facilities.index', compact('facilities'));
    }
}
