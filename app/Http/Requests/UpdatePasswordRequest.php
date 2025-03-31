<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação da requisição.
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Mensagens personalizadas para as regras de validação.
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'A senha atual é obrigatória.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.confirmed' => 'A confirmação da nova senha não coincide.',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
        ];
    }
}
