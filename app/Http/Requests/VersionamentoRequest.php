<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VersionamentoRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string'
        ];
    }

        public function messages()
    {
        return [
            'titulo.required' => 'É obrigatório a inserção de um título para o versionamento',
            'titulo.string' => 'O título deve ser um texto',
            'titulo.max' => 'O título não deve exceder 255 caracteres',

            'descricao.required' => 'A descrição é obrigatória',
            'descricao.string' => 'A descrição deve ser um texto',
        ];
    }

}
