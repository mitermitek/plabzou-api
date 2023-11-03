<?php

namespace App\Http\Requests\API\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestRequest extends FormRequest
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
            'timeslot_id' => 'required|integer|sometimes',
            'teacher_id' => 'required|integer|sometimes',
            'administrative_employee_id' => 'required|integer|sometimes',
            'comment' => 'string|min:2|max:255|nullable|sometimes',
            'is_approved_by_admin' => 'boolean|nullable',
            'is_approved_by_teacher' => 'boolean|nullable',
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
            'timeslot_id.required' => 'Veuillez sélectionner un créneau',
            'teacher_id.required' => 'Veuillez sélectionner un formateur',
            'comment.min' => 'Le commentaire doit avoir au minimum 2 caractères',
            'comment.max' => 'Le commentaire doit avoir au maximum 255 caractères',
        ];
    }
}
