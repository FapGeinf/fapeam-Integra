<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanoAcaoRequest extends FormRequest
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
            'eixo_id'        => 'required|exists:eixos,id',
            'responsavel_id' => 'required|exists:users,id',
            'indicador_id'   => 'required|exists:indicadores,id',
            'objetivo'       => 'required|string',
            'descricao_acao' => 'required|string',
            'meta'           => 'nullable|numeric',
            'procedimentos'  => 'nullable|string',
            'metricas'       => 'nullable|string',
            'prazo_execucao' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'eixo_id.required'        => 'O campo eixo é obrigatório.',
            'eixo_id.exists'          => 'O eixo selecionado é inválido.',
            'responsavel_id.required' => 'O responsável é obrigatório.',
            'responsavel_id.exists'   => 'O usuário responsável selecionado é inválido.',
            'indicador_id.required'   => 'O indicador é obrigatório.',
            'indicador_id.exists'     => 'O indicador selecionado é inválido.',
            'objetivo.required'       => 'O objetivo é obrigatório.',
            'descricao_acao.required' => 'A descrição da ação é obrigatória.',
            'meta.numeric'            => 'A meta deve ser um valor numérico.',
            'prazo_execucao.date'     => 'O prazo de execução deve ser uma data válida.',
        ];
    }
}