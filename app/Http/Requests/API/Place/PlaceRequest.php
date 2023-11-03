<?php

namespace App\Http\Requests\API\Place;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceRequest extends FormRequest
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
                Rule::unique('places', 'name')->ignore($this->place?->id),
            ],
            'street_address' => ['required', 'string'],
            'city_id' => [
                'required',
                'exists:cities,id'
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
            'street_address.required' => 'L\'adresse est obligatoire.',
            'street_address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'city.required' => 'La ville est obligatoire.',
            'city.exists' => 'La ville n\'existe pas.'
        ];
    }
}
