<?php

namespace App\Http\Requests\API\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrentUserRequest extends FormRequest
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
            'phone_number' => [
                'required',
                'string',
                'max:12',
                'min:12',
                Rule::unique('users', 'phone_number')->ignore($this->user()->id)
            ],
            'current_password' => [
                Rule::requiredIf(fn() => $this->new_password),
                'current_password'
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'password_confirm' => [
                Rule::requiredIf(fn() => $this->new_password),
                'same:password'
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
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone_number.max' => 'Le numéro de téléphone ne doit pas dépasser 12 caractères.',
            'phone_number.min' => 'Le numéro de téléphone doit contenir 12 caractères.',
            'phone_number.unique' => 'Le numéro de téléphone est déjà utilisé.',
            'current_password.required' => 'Le mot de passe actuelle est nécessaire pour le modifier.',
            'current_password.current_password' => 'Mauvais mot de passe.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password_confirm.required' => 'Confirmez le nouveau mot de passe.',
            'password_confirm.same' => 'Les 2 mots de passe ne sont pas identique.'
        ];
    }
}
