<?php

namespace App\Http\Requests\API\User;

use App\Enums\StatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
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
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone_number' => [
                'required',
                'string',
                'max:12',
                'min:12',
                Rule::unique('users', 'phone_number')->ignore($this->user?->id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user?->id)
            ],
            'password' => (!$this->user?->id || $this->password) ? ['required', 'string', 'min:8'] : ['nullable'],
            'is_super_admin' => ['sometimes', 'boolean'],
            'teacher_status' => ['sometimes', 'string', new Enum(StatusEnum::class)],
            'learner_mode' => ['sometimes', 'exists:modes,id'],
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
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'last_name.required' => 'Le nom est obligatoire.',
            'last_name.string' => 'Le nom doit être une chaîne de caractères.',
            'last_name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone_number.max' => 'Le numéro de téléphone ne doit pas dépasser 12 caractères.',
            'phone_number.min' => 'Le numéro de téléphone doit contenir 12 caractères.',
            'phone_number.unique' => 'Le numéro de téléphone est déjà utilisé.',
            'email.required' => 'L\'adresse mail est obligatoire.',
            'email.email' => 'L\'adresse mail doit être une adresse mail valide.',
            'email.unique' => 'L\'adresse mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'is_super_admin.boolean' => 'Le champ super administrateur doit être un booléen.',
            'teacher_status.string' => 'Le statut du formateur doit être une chaîne de caractères.',
            'teacher_status.enum' => 'Le statut du formateur doit être un des statuts suivants : ' . implode(', ', collect(StatusEnum::cases())->pluck('value')->toArray()),
            'learner_mode.exists' => 'Le mode de l\'apprenant doit être un mode existant.',
        ];
    }
}
