<?php

namespace App\Http\Requests\API\Promotion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromotionRequest extends FormRequest
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
                Rule::unique('promotions', 'name')->ignore($this->promotion?->id),
            ],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'course' => ['required', 'integer', 'exists:courses,id'],
            'city' => ['nullable', 'integer', 'exists:cities,id'],
            'learners' => ['nullable', 'array'],
            'learners.*.user_id' => ['nullable', 'exists:users,id'],
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
            'starts_at.required' => 'La date de début est obligatoire.',
            'starts_at.date' => 'La date de début doit être une date.',
            'ends_at.required' => 'La date de fin est obligatoire.',
            'ends_at.date' => 'La date de fin doit être une date.',
            'ends_at.after' => 'La date de fin doit être postérieure à la date de début.',
            'course.required' => 'Le cursus est obligatoire.',
            'course.integer' => 'Le cursus doit être un entier.',
            'course.exists' => 'Le cursus n\'existe pas.',
            'city.integer' => 'La ville doit être un entier.',
            'city.exists' => 'La ville n\'existe pas.',
            'learners.array' => 'Les apprenants doivent être un tableau.',
            'learners.*.user_id.exists' => 'L\'apprenant n\'existe pas.',
        ];
    }
}
