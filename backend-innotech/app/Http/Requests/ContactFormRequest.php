<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'service' => 'required|in:scolarite,bibliotheque,administration',
            'message' => 'required|string|min:10'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('validation.attributes.name'),
            'email' => __('validation.attributes.email'),
            'service' => __('validation.attributes.service'),
            'message' => __('validation.attributes.message'),
        ];
    }
}
