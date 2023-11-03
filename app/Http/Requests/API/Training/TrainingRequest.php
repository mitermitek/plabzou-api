<?php

namespace App\Http\Requests\API\Training;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrainingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('trainings', 'name')->ignore($this->training?->id),
            ],
            'duration' => [
                'required',
                'integer',
            ],
            'categories' => ['array', 'nullable'],
            'categories.*.id' => [
                'required',
                'exists:App\Models\Category,id'
            ],
            'courses' => ['array', 'nullable'],
            'courses.*.id' => [
                'required',
                'exists:App\Models\Course,id'
            ],
            'teachers' => ['array', 'nullable'],
            'teachers.*.user_id' => [
                'required',
                'exists:App\Models\Teacher,user_id'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.unique' => 'Le nom est déjà utilisé.',
            'duration.required' => 'La durée est obligatoire.',
            'duration.integer' => 'La durée doit être un nombre entier.',
            'categories.*.id.exists' => 'Catégorie invalide.',
            'courses.*.id.exists' => 'Formation invalide.',
            'teachers.*.user_id.exists' => 'Formateur invalide.',
        ];
    }
}
