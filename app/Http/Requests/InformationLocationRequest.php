<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationLocationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atur sesuai kebutuhan otorisasi
    }
    
    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'lattitude' => 'required|string|max:255',
            'position_1' => 'required|string|max:255',
            'position_2' => 'required|string|max:255',
            'position_3' => 'required|string|max:255',
            'position_4' => 'nullable|string|max:255', // Tidak wajib diisi
            'position_5' => 'nullable|string|max:255', // Tidak wajib diisi
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'Address wajib diisi',
            'address.max' => 'Address tidak boleh lebih dari 255 karakter',
            'longitude.required' => 'Longitude wajib diisi',
            'longitude.max' => 'Longitude tidak boleh lebih dari 255 karakter',
            'lattitude.required' => 'Lattitude wajib diisi',
            'lattitude.max' => 'Lattitude tidak boleh lebih dari 255 karakter',
            'position_1.required' => 'Position 1 wajib diisi',
            'position_1.max' => 'Position 1 tidak boleh lebih dari 255 karakter',
            'position_2.required' => 'Position 2 wajib diisi',
            'position_2.max' => 'Position 2 tidak boleh lebih dari 255 karakter',
            'position_3.required' => 'Position 3 wajib diisi',
            'position_3.max' => 'Position 3 tidak boleh lebih dari 255 karakter',
            'position_4.max' => 'Position 4 tidak boleh lebih dari 255 karakter',
            'position_5.max' => 'Position 5 tidak boleh lebih dari 255 karakter',
        ];
    }
}
