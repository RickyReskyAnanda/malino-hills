<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationSocMedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sosmed_ig' => ['required', 'url', 'max:255'],
            'sosmed_tiktok' => ['required', 'url', 'max:255'],
            'sosmed_facebook' => ['required', 'url', 'max:255'],
            'sosmed_youtube' => ['required', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'sosmed_ig.required' => 'URL Instagram wajib diisi',
            'sosmed_ig.url' => 'Format URL Instagram tidak valid',
            'sosmed_tiktok.required' => 'URL TikTok wajib diisi',
            'sosmed_tiktok.url' => 'Format URL TikTok tidak valid',
            'sosmed_facebook.required' => 'URL Facebook wajib diisi',
            'sosmed_facebook.url' => 'Format URL Facebook tidak valid',
            'sosmed_youtube.required' => 'URL Youtube wajib diisi',
            'sosmed_youtube.url' => 'Format URL Youtube tidak valid',
        ];
    }
}
