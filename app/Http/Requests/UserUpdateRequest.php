<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user'); // Obtém o ID do usuário da rota

        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email' . $userId,
            'cpf' => 'nullable|unique:users,cpf,' . $userId,
            'password' => 'nullable|min:8',
            'password_confirmation' => 'nullable|required_with:password|same:password|min:8',
            'unidadeIdFK' => 'nullable|exists:unidades,id',
        ];
    }

    /**
     * Customiza as mensagens de erro para cada regra de validação.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.string' => 'O nome deve ser um texto válido.',

            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',

            'cpf.unique' => 'Este CPF já está cadastrado.',

            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password_confirmation.required_with' => 'A confirmação de senha é obrigatória quando uma senha é fornecida.',
            'password_confirmation.same' => 'A confirmação de senha deve ser igual à senha.',

            'unidadeIdFK.exists' => 'A unidade selecionada não é válida.',
        ];
    }
}
