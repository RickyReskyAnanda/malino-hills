<?php

namespace App\Http\Controllers\Public;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        $gallery = Image::select('path_portrait')
        ->where('type',ImageType::GALLERY)
        ->inRandomOrder()
        ->limit(32)
        ->pluck('path_portrait');
        return view('landing-page.gallery.index', compact('gallery'));
    }
}
