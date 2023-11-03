<?php

namespace App\Http\Requests\API\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
                Rule::unique('courses', 'name')->ignore($this->course?->id),
            ],
            'trainings' => ['required', 'array'],
            'trainings.*.id' => ['required', 'exists:trainings,id'],
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
            'trainings.required' => 'Les formations sont obligatoires.',
            'trainings.array' => 'Les formations doivent être un tableau.',
            'trainings.*.id.required' => 'La formation est obligatoire.',
            'trainings.*.id.exists' => 'La formation n\'existe pas.',
        ];
    }
}
