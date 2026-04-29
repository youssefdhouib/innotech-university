<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to false if you implement auth later
    }

    public function rules(): array
    {
        return [
            'category' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'is_published' => 'required|boolean',
            'image_url' => 'nullable|string|max:255',

            // Validate translations array
            'translations' => 'required|array|min:1',
            'translations.*.codeLang' => 'required|string|in:fr,en,ar',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.location' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'The category field is required.',
            'translations.required' => 'At least one translation is required.',
            'translations.*.codeLang.in' => 'codeLang must be one of: fr, en, ar.',
            'translations.*.title.required' => 'Title is required for each translation.',
        ];
    }
}
