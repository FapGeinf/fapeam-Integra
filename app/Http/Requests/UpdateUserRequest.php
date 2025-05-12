<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id'); 

        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $userId, 
            'cpf' => 'nullable|unique:users,cpf,' . $userId, 
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|required_with:password|same:password|min:8',
            'unidadeIdFK' => 'nullable|exists:unidades,id',
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
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            
            'cpf.unique' => 'Este CPF já está cadastrado.',
            
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            
            'password_confirmation.required_with' => 'A confirmação da senha é obrigatória quando a senha é informada.',
            'password_confirmation.same' => 'As senhas não coincidem.',
            'password_confirmation.min' => 'A confirmação da senha deve ter pelo menos 8 caracteres.',
            
            'unidadeIdFK.exists' => 'A unidade selecionada não existe.',
        ];
    }
}
