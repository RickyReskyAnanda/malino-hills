<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\StatusType;
use App\Functions\SheetHelper;
use App\Http\Controllers\Controller;
use App\Jobs\CreateSheet;
use App\Jobs\DeleteBookingSheet;
use App\Jobs\UpdateBookingSheet;
use App\Models\Booking;
use App\Models\Villa;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use DB;

use Carbon\Carbon;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = (int)$request->input('month', date('m'));

        CreateSheet::dispatch("{$year}-{$month}-01");

        $data = DB::select("
            SELECT
                a.villa_id,
                a.number,
                c.`name` as villa,
                d.villa_count,
                b.d_1,
                b.d_2,
                b.d_3,
                b.d_4,
                b.d_5,
                b.d_6,
                b.d_7,
                b.d_8,
                b.d_9,
                b.d_10,
                b.d_11,
                b.d_12,
                b.d_13,
                b.d_14,
                b.d_15,
                b.d_16,
                b.d_17,
                b.d_18,
                b.d_19,
                b.d_20,
                b.d_21,
                b.d_22,
                b.d_23,
                b.d_24,
                b.d_25,
                b.d_26,
                b.d_27,
                b.d_28,
                b.d_29,
                b.d_30,
                b.d_31
            FROM (
                SELECT 
                    villa_id,
                    number
                FROM app_villas_number
            ) a
            LEFT JOIN (
                SELECT
                    *
                FROM app_villas 
            ) c ON a.villa_id = c.id_villa

            LEFT JOIN 
            ( SELECT 
                villa_id,
                number, 
                SUM(IF(day(date) = 1,1,0)) as d_1,
                SUM(IF(day(date) = 2,1,0)) as d_2,
                SUM(IF(day(date) = 3,1,0)) as d_3,
                SUM(IF(day(date) = 4,1,0)) as d_4,
                SUM(IF(day(date) = 5,1,0)) as d_5,
                SUM(IF(day(date) = 6,1,0)) as d_6,
                SUM(IF(day(date) = 7,1,0)) as d_7,
                SUM(IF(day(date) = 8,1,0)) as d_8,
                SUM(IF(day(date) = 9,1,0)) as d_9,
                SUM(IF(day(date) = 10,1,0)) as d_10,
                SUM(IF(day(date) = 11,1,0)) as d_11,
                SUM(IF(day(date) = 12,1,0)) as d_12,
                SUM(IF(day(date) = 13,1,0)) as d_13,
                SUM(IF(day(date) = 14,1,0)) as d_14,
                SUM(IF(day(date) = 15,1,0)) as d_15,
                SUM(IF(day(date) = 16,1,0)) as d_16,
                SUM(IF(day(date) = 17,1,0)) as d_17,
                SUM(IF(day(date) = 18,1,0)) as d_18,
                SUM(IF(day(date) = 19,1,0)) as d_19,
                SUM(IF(day(date) = 20,1,0)) as d_20,
                SUM(IF(day(date) = 21,1,0)) as d_21,
                SUM(IF(day(date) = 22,1,0)) as d_22,
                SUM(IF(day(date) = 23,1,0)) as d_23,
                SUM(IF(day(date) = 24,1,0)) as d_24,
                SUM(IF(day(date) = 25,1,0)) as d_25,
                SUM(IF(day(date) = 26,1,0)) as d_26,
                SUM(IF(day(date) = 27,1,0)) as d_27,
                SUM(IF(day(date) = 28,1,0)) as d_28,
                SUM(IF(day(date) = 29,1,0)) as d_29,
                SUM(IF(day(date) = 30,1,0)) as d_30,
                SUM(IF(day(date) = 31,1,0)) as d_31
            FROM `app_booking`
            WHERE 
            YEAR(`date`) = {$year} 
            AND MONTH(`date`) = {$month}
            GROUP BY 1,2 ) b ON a.villa_id = b.villa_id AND a.number = b.number
            LEFT JOIN app_villas d  ON a.villa_id = d.id_villa
        ");

        return response()->json(ResponseFormat::format(
            200,
            "",
            $data
        ));
    }

    public function update(Request $request)
    {

        $date = $request->input('date', 0);
        $status = $request->input('status', 0);
        $villa_id = $request->input('villa_id', 0);
        $number = $request->input('room_number', 0);

        if ($status == 1) {
            Booking::create([
                'villa_id' =>  $villa_id,
                'number' =>  $number,
                'date' =>  $date,
            ]);
        } else {
            Booking::where(function ($q) use ($villa_id, $number, $date) {
                $q->where('villa_id', $villa_id);
                $q->where('number',  $number);
                $q->where('date',  $date);
            })->delete();
            
            DeleteBookingSheet::dispatch([
                'villa_id' => $villa_id,
                'room_number' => $number,
                'date' => $date,
            ]);
        }

        return response()->json(
            ResponseFormat::format(
                200,
                'Booking updated',
            ),
            200
        );
    }

    public function getVilla(Request $request)
    {
        $data = Villa::select('id_villa as value', 'name as label', 'villa_count')
            ->where('status', StatusType::PUBLISHED)
            ->get();

        return response()->json(ResponseFormat::format(
            200,
            "",
            $data
        ));
    }


    public function storeBulk(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reservations' => 'required|array',
            'reservations.*.villa_id' => 'required|integer',
            'reservations.*.room_number' => 'required|integer',
            'reservations.*.start_date' => 'required|date',
            'reservations.*.end_date' => 'required|date',
        ]);

        $rows = [];

        foreach ($validated['reservations'] as $reservation) {
            $start = Carbon::parse($reservation['start_date']);
            $end = Carbon::parse($reservation['end_date']);

            // Tukar tanggal jika start > end
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            // Hitung tanggal yang disimpan
            if ($start->eq($end)) {
                $dates = [$start];
            } else {
                $dates = [];
                for ($date = $start->copy(); $date->lt($end); $date->addDay()) {
                    $dates[] = $date->copy();
                }
            }

            foreach ($dates as $date) {
                $rows[] = [
                    'name' => $request->name,
                    'villa_id' => $reservation['villa_id'],
                    'room_number' => $reservation['room_number'],
                    'date' => $date->toDateString(),
                    'day' => (int)$date->format('d'),
                    'ym' => $date->format('Y-m'),
                ];
            }
        }

        foreach ($rows as $row) {
            Booking::updateOrCreate(
                [
                    'villa_id' => $row['villa_id'],
                    'number' => $row['room_number'],
                    'date' => $row['date'],
                ],
                [
                    'updated_at' => now(),
                    'name' => $validated['name'],
                ]
            );
        }
        $grouped = collect($rows)->groupBy('ym');


        UpdateBookingSheet::dispatch($grouped->toArray());


        return response()->json(ResponseFormat::format(
            200,
        "Booking data updated successfully",
        ),200);
    }
}
