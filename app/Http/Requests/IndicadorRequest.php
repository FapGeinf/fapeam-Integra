<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicadorRequest extends FormRequest
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
            'nomeIndicador' => 'required|string|max:255',
            'descricaoIndicador' => 'required|string',
            'eixo_fk' => 'required|exists:eixos,id',
        ];
    }

    public function messages()
    {
        return [
            'nomeIndicador.required' => 'O campo Nome do Indicador é obrigatório.',
            'nomeIndicador.string' => 'Por favor, o campo Nome do Indicador deve ser do tipo texto.',
            'nomeIndicador.max' => 'O nome não deve exceder o limite de 255 caracteres.',

            'descricaoIndicador.required' => 'O campo Descrição é obrigatório.',
            'descricaoIndicador.string' => 'O campo Descrição deve ser do tipo texto.',

            'eixo_fk.required' => 'Por favor, selecione um eixo.',
            'eixo_fk.exists' => 'Por favor, escolha um eixo que exista.'
        ];
    }


}
