<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'degree_id' => 'required|exists:degrees,id',
            'attached_file' => 'nullable|string',
            'translations' => 'required|array',
            'translations.fr.description' => 'required|array',
            'translations.fr.description.intro' => 'required|string',
            'translations.fr.description.modules' => 'required|array',
            'translations.en.description' => 'nullable|array',
            'translations.ar.description' => 'nullable|array',
        ];
    }
}
