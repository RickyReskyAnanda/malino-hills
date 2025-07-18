<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_wa' => 'required|regex:/^62[0-9]{9,}$/',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'no_wa.regex' => 'Nomor WhatsApp harus berawalan 62 dan terdiri dari minimal 10 digit',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
        ];
    }
}