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
            'nomeIndicador' => 'nullable|string|max:255',
            'descricaoIndicador' => 'nullable|string',
            'eixo_fk' => 'nullable|exists:eixos,id',
        ];
    }

    public function messages()
    {
        return [
            'nomeIndicador.string' => 'Por favor, o campo Nome do Indicador deve ser do tipo texto.',
            'nomeIndicador.max' => 'O nome não deve exceder o limite de 255 caracteres.',
            'descricaoIndicador.string' => 'O campo Descrição deve ser do tipo texto.',
            'eixo_fk.exists' => 'Por favor, escolha um eixo que exista.'
        ];
    }

}
