<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertIndicadorRequest extends FormRequest
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
            'nomeIndicador' => 'nullable|string|max:255',
            'descricaoIndicador' => 'nullable|string',
            'eixo_fk' => 'nullable|exists:eixos,id',
        ];
    }

    public function messages()
    {
           return [
              'nomeIndicador.string' => 'O nome deve ser do tipo texto',
              'nomeIndicador.max' => 'O nome deve ter no máximo 255 caracteres',
              'descricaoIndicador.string' => 'A descrição deve ser do tipo texto',
              'eixo_fk.exists' => 'O eixo selecionado não existe'
           ];
    }
}
