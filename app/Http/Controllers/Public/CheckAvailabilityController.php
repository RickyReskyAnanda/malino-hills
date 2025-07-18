<?php

namespace App\Http\Controllers\Public;

use App\Enums\ImageType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Experience;
use App\Models\Image;
use App\Models\Villa;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class CheckAvailabilityController extends Controller
{
    public function index(Request $request){
        // Ambil input rentang tanggal
        $dateRange = $request->input('date',  date('d M Y').' - '.date('d M Y', strtotime('+ 1 day')));

        // Pecah rentang tanggal menjadi start dan end
        $dates = explode(' - ', $dateRange);
        $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]))->format('Y-m-d');


        $endDateFilter = $endDate;
        if ($startDate != $endDate) {
            $endDateFilter = Carbon::parse($endDate)->subDay()->format('Y-m-d');
        }

        $villaId = DB::select("
            SELECT
                a.id_villa
            FROM ( SELECT id_villa, name, villa_count FROM app_villas) a
            LEFT JOIN 
            ( 
                SELECT 
                    villa_id,
                    count(DISTINCT number) as villa_count 
                FROM `app_booking`
                WHERE 
                    `date` BETWEEN '{$startDate}' AND '{$endDateFilter}'
                GROUP BY 1
            ) b ON a.id_villa = b.villa_id
            WHERE 
                b.villa_id IS NULL OR (a.villa_count - b.villa_count) > 0
        ");
        $villaId = array_column($villaId, 'id_villa');
        $data = Villa::with([
            'slideImages',
            'highlightFacilities'=> function ($q){
                $q->where('status',StatusType::PUBLISHED);
            },
            'highlightFacilities.icon',
            'booking' => function($q) use ($startDate, $endDateFilter){
                $q->select('villa_id','number');
                $q->whereBetween('date',[$startDate, $endDateFilter]);
                $q->groupBy('villa_id','number');
            }
        ])
        // ->whereIn('id_villa', $villaId)
        ->get();

        return view('landing-page.check-availability.index', compact('startDate','endDate','data'));
    }

    public function checking(Request $request){
        // Ambil input rentang tanggal
        $dateRange = $request->input('dates');

        // Pecah rentang tanggal menjadi start dan end
        $dates = explode(' - ', $dateRange);

        // Pastikan array $dates memiliki dua elemen (start dan end date)
        if (count($dates) == 2) {
            $villa = Villa::find($request->villa_id);
            

            // Format tanggal menggunakan Carbon
            $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]))->format('Y-m-d');


            $endDateFilter = $endDate;
            if ($startDate != $endDate) {
                $endDateFilter = Carbon::parse($endDate)->subDay()->format('Y-m-d');
            }

            $bookingCount =  Booking::whereBetween('date',[$startDate, $endDateFilter])
                ->where('villa_id',$request->villa_id)
                ->orderBy('number','asc')
                ->count();


            if($bookingCount < $villa->villa_count) 
                return response()->json(ResponseFormat::format(200, "Available ".($villa->villa_count - $bookingCount)." Villas",['available'=>$villa->villa_count - $bookingCount]),200); 
            else
            return response()->json(ResponseFormat::format(400, "Villas Not Available"),200); 
        } else {
            return response()->json(ResponseFormat::format(500, 'Format tanggal tidak valid'),200); 
        }
    }

}
