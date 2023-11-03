<?php

namespace App\Http\Requests\API\Building;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BuildingRequest extends FormRequest
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
                Rule::unique('buildings', 'name')->ignore($this->building?->id),
            ],
            'place_id' => [
                'required',
                'exists:places,id'
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
            'place_id.required' => 'Le lieu est obligatoire.',
            'place_id.exists' => 'Le lieu n\'existe pas.'
        ];
    }
}
