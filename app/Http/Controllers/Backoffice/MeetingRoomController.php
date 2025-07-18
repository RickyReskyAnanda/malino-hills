<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Utils\ResponseFormat;
use App\Http\Requests\MeetingRoomRequest;
use App\Models\Venue;

class MeetingRoomController extends Controller
{
    public function index()
    {
        $venue = Venue::find(1);
        return response()->json(ResponseFormat::format(
            200,
            '',
            (object)[
                'title' => $venue->title ?? '',
                'description' => $venue->description ?? ''
            ],
        ));
    }
    
    public function update(MeetingRoomRequest $request)
    {   
        try {
            // Mendapatkan data yang sudah tervalidasi
            $payload = $request->validated();

            // Simpan data ke database dan dapatkan ID baru
            $venue = Venue::find(1);
            $venue->title = $payload['title'];
            $venue->description = $payload['description'];
            $venue->save();

            return response()->json(ResponseFormat::format(
                200,
                "Meeting Room Information updated"
            ));

        } catch (ValidationException $e) {
            // Ambil satu error saja
            $firstError = $e->validator->errors()->first();
            // Kembalikan response dengan satu error
            return response()->json(ResponseFormat::format(400,$firstError), 200);
        } catch (\Throwable $th) {
            return response()->json(ResponseFormat::format(500,$th->getMessage()), 200);
        }
    }
}
