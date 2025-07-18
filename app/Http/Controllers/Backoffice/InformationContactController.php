<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Utils\ResponseFormat;
use App\Http\Requests\InformationContactRequest;

class InformationContactController extends Controller
{
    public function index()
    {
                
            $information = Information::find(1);

        return response()->json(ResponseFormat::format(
            200,
            '',
            (object)[
                'no_wa' => $information->whatsapp ?? '',
                'email' => $information->email ?? ''
            ],
        ));
    }
    
    public function update(InformationContactRequest $request)
    {   
        try {
            // Mendapatkan data yang sudah tervalidasi
            $payload = $request->validated();

            // Simpan data ke database dan dapatkan ID baru
            $information = Information::find(1);
            $information->whatsapp = $payload['no_wa'];
            $information->email = $payload['email'];
            $information->save();

            return response()->json(ResponseFormat::format(
                200,
                "Information Contact updated"
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
