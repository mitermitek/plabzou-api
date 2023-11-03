<?php

namespace App\Http\Requests\API\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'sender_id' => 'required|integer',
            'conversation_id' => 'required|integer',
            //TODO changer la valeur max
            'message' => 'required|string|max:255|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Le message est obligatoire',
            'message.string' => 'Le message doit être une chaîne de caractères',
            'message.min' => 'Le message ne peut être vide',
            'message:max' => 'Le message ne doit pas dépasser 255 caractères',
        ];
    }
}
