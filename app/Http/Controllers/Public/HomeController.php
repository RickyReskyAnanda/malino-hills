<?php

namespace App\Http\Controllers\Public;

use App\Enums\ImageType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Facility;
use App\Models\Image;
use App\Models\Villa;
use Illuminate\Http\Request;

class HomeController extends Controller
{ 
    public function index(Request $request){
        if($request->segment(1) != 'id' && $request->segment(1) != 'en')
            return redirect('/en');

        $gallery = Image::select('path_original')
        ->where('type',ImageType::GALLERY)
        ->inRandomOrder()
        ->limit(15)
        ->pluck('path_original');

        $experience = Experience::with('thumbnail')
        ->where('status', StatusType::PUBLISHED)
        ->inRandomOrder()
        ->limit(12)
        ->get();

        $villa = Villa::with([
                'images',
                'highlightFacilities'=> function ($q){
                    $q->where('status',StatusType::PUBLISHED);
                },
                'highlightFacilities.icon'
            ])
            ->where('status',StatusType::PUBLISHED)
            ->has('images')
            ->get();
        
        $facilities = Facility::with('thumbnail')->where('status',StatusType::PUBLISHED)
            ->inRandomOrder()
            ->get();
        $slideFacility = [];
        foreach($facilities as $key => $d){
            if($d->thumbnail?->path_original){
                $slideFacility[] =  $d->thumbnail?->path_original;
            }
        }

        $venueImage = Image::where('type',ImageType::VENUE)
            ->inRandomOrder()
            ->limit(2)
            ->get();
        foreach($venueImage as $key => $d){
            if($d->path_original){
                $slideFacility[] =  $d->path_original;
            }
        }

        return view('landing-page.home.index', compact('gallery','experience', 'villa','slideFacility'));
    }

}
