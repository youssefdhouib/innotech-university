<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DegreeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => 'required|string|max:255',
            'cover_image' => 'nullable|string',
            'translations' => 'required|array',
            'translations.fr.name' => 'required|string|max:255',
            'translations.en.name' => 'nullable|string|max:255',
            'translations.ar.name' => 'nullable|string|max:255',
        ];
    }
}
