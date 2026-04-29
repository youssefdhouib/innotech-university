<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfessorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        $professorId = $this->route('professor')?->id;

        return [
            'email' => [
                $isUpdate ? 'sometimes' : 'required',
                'email',
                'max:255',
                'unique:professors,email' . ($isUpdate ? ",$professorId" : '')
            ],
            'profile_slug' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                'unique:professors,profile_slug' . ($isUpdate ? ",$professorId" : '')
            ],
            'photo_url' => 'nullable|string',
            'cv_attached_file' => 'nullable|string',
            'department_id' => $isUpdate ? 'sometimes|exists:departments,id' : 'required|exists:departments,id',

            'translations' => 'required|array',
            'translations.fr.first_name' => 'required|string|max:255',
            'translations.fr.last_name' => 'required|string|max:255',
            'translations.fr.speciality' => 'nullable|string|max:255',
            'translations.fr.grade' => 'nullable|string|max:255',
            'translations.en.first_name' => 'required|string|max:255',
            'translations.en.last_name' => 'required|string|max:255',
            'translations.ar.first_name' => 'required|string|max:255',
            'translations.ar.last_name' => 'required|string|max:255',
        ];
    }
}
