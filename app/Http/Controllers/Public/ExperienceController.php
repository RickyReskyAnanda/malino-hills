<?php

namespace App\Http\Controllers\Public;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(){
        $experiences = Experience::where('status', StatusType::PUBLISHED)
        ->inRandomOrder()
        ->limit(36)
        ->get();
        return view('landing-page.experience.index', compact('experiences'));
    }
    public function show($id){
        $experience = Experience::with('thumbnail','slideImages')
        ->where('status', StatusType::PUBLISHED)
        ->where('id_experience', $id)
        ->firstOrFail();

        $others = Experience::where('status', StatusType::PUBLISHED)
        ->inRandomOrder()
        ->limit(8)
        ->where('id_experience','!=',$id)
        ->get();

        return view('landing-page.experience.detail.index',compact('experience','others'));
    }
}
