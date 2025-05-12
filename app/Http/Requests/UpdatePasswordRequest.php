<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'old_password.required' => 'O campo senha antiga é obrigatório.',
            'new_password.required' => 'O campo nova senha é obrigatório.',
            'new_password.confirmed' => 'A confirmação da nova senha não corresponde.',
            'new_password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
        ];
    }
}
