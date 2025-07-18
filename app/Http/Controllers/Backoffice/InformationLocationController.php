<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Utils\ResponseFormat;
use App\Http\Requests\InformationLocationRequest;

class InformationLocationController extends Controller
{
    public function index()
    {
                
        $information = Information::first();

        return response()->json(ResponseFormat::format(
            200,
            '',
            (object)[
                'address' => $information->address,
                'longitude' => $information->maps_longitude,
                'lattitude' => $information->maps_lattitude,
                'position_1' => $information->position_1,
                'position_2' => $information->position_2,
                'position_3' => $information->position_3,
                'position_4' => $information->position_4,
                'position_5' => $information->position_5,
            ],
        ));
    }
    
    public function update(InformationLocationRequest $request)
    {   
        try {
            // Mendapatkan data yang sudah tervalidasi
            $payload = $request->validated();

            // Simpan data ke database dan dapatkan ID baru
            $information = Information::find(1);

            $information->address = $payload['address'];
            $information->maps_longitude = $payload['longitude'];
            $information->maps_lattitude = $payload['lattitude'];
            $information->position_1 = $payload['position_1'];
            $information->position_2 = $payload['position_2'];
            $information->position_3 = $payload['position_3'];
            $information->position_4 = $payload['position_4'];
            $information->position_5 = $payload['position_5'];
            $information->save();

            return response()->json(ResponseFormat::format(
                200,
                "Information Location updated"
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
