<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Utils\ResponseFormat;
use App\Http\Requests\InformationSocMedRequest;

class InformationSocMedController extends Controller
{
    public function index()
    {
                
            $information = Information::find(1);

        return response()->json(ResponseFormat::format(
            200,
            '',
            (object)[
                'sosmed_youtube' => $information->youtube,
                'sosmed_facebook' => $information->facebook,
                'sosmed_ig' => $information->instagram,
                'sosmed_tiktok' => $information->tiktok,
            ],
        ));
    }
    
    public function update(InformationSocMedRequest $request)
    {   
        try {
            // Mendapatkan data yang sudah tervalidasi
            $payload = $request->validated();

            // Simpan data ke database dan dapatkan ID baru
            $information = Information::find(1);

            $information->tiktok = $payload['sosmed_tiktok'];
            $information->facebook = $payload['sosmed_facebook'];
            $information->instagram = $payload['sosmed_ig'];
            $information->youtube = $payload['sosmed_youtube'];
            $information->save();

            return response()->json(ResponseFormat::format(
                200,
                "Information SocMed updated"
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
