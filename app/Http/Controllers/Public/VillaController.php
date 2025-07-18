<?php

namespace App\Http\Controllers\Public;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Villa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VillaController extends Controller
{
    public function index(){
        $villa = Villa::with([
                'images',
                'highlightFacilities' => function ($q){
                    $q->where('status',StatusType::PUBLISHED);
                },
                'highlightFacilities.icon',
                'slideImages',
            ])
            ->where('status', StatusType::PUBLISHED)
            ->has('images')
            ->has('slideImages')
            ->has('highlightFacilities')
            ->get();

        return view('landing-page.villas.index', compact('villa'));
    }

    public function show($id,$name){
        $dateRange = date('d M Y').' - '.date('d M Y', strtotime('+ 1 day'));

        // Pecah rentang tanggal menjadi start dan end
        $dates = explode(' - ', $dateRange);
        $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]))->format('Y-m-d');

        $villa = Villa::with([
                'images',
                'slideImages',
                'highlightFacilities'=> function ($q){
                    $q->where('status',StatusType::PUBLISHED);
                    $q->limit(4);
                },
                'highlightFacilities.icon',
                'facilities'=> function ($q){
                    $q->where('status',StatusType::PUBLISHED);
                },
            ])
            ->where('status',StatusType::PUBLISHED)
            ->where('id_villa', $id)
            ->firstOrFail();
      
        $othersVilla = Villa::with([
            'images',
            'highlightFacilities'=> function ($q){
                $q->where('status',StatusType::PUBLISHED);
            },
            'highlightFacilities.icon'
        ])
        ->where('status',StatusType::PUBLISHED)
        ->where('id_villa','!=', $id)
        ->has('images')
        ->get();

        return view('landing-page.villas.detail.index',compact('villa','othersVilla','startDate','endDate'));
    }
}
