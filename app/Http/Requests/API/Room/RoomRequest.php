<?php

namespace App\Http\Requests\API\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
                Rule::unique('rooms', 'name')->ignore($this->room?->id),
            ],
            'seats_number' => [
                'required',
                'integer',
                'min:1'
            ],
            'building_id' => [
                'required',
                'exists:buildings,id'
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
            'seats_number.required' => 'Le nombre de place est obligatoire.',
            'seats_number.integer' => 'Le nombre de place doit être un chiffre entier.',
            'seats_number.min' => 'Le nombre de place doit être supérieur à 0.',
            'place_id.required' => 'Le bâtiment est obligatoire.',
            'place_id.exists' => 'Le bâtiment n\'existe pas.'
        ];
    }
}
