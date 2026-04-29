<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponseTrait;


class PreinscriptionRequest extends FormRequest
{
    use ApiResponseTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'first_name_ar' => 'required|string|max:100', // الاسم
            'last_name_ar' => 'required|string|max:100',  // اللقب
            'email' => 'required|email|unique:applications,email',
            'cin' => 'required|unique:applications,cin',
            'passport' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'country' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'previous_degree' => 'required|string|max:100',
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'how_did_you_hear' => 'nullable|string|max:255',
            'desired_degree_id' => 'nullable|exists:degrees,id',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse(__('messages.validation_error'), $validator->errors()->toArray(), 422)
        );

    }
}
