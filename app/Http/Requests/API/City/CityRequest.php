<?php

namespace App\Http\Requests\API\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('cities', 'name')->ignore($this->city?->id),
            ],
            'postcode' => [
                'required',
                'string',
                'size:5'
            ]
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
            'postcode.required' => 'Le code postal est obligatoire.',
            'postcode.string' => 'Le code postal doit être une chaîne de caractères.',
            'postcode.size' => 'Le code postal doit être exactement 5 caractères.',
        ];
    }
}
