<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cover_image' => 'nullable|string',
            'translations.fr.name' => 'required|string|max:255',
            'translations.fr.description' => 'nullable|string',
            'translations.en.name' => 'required|string|max:255',
            'translations.en.description' => 'nullable|string',
            'translations.ar.name' => 'required|string|max:255',
            'translations.ar.description' => 'nullable|string',
        ];
    }
}

