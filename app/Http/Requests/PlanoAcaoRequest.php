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
            'eixos'          => 'required|array|min:1',
            'eixos.*'        => 'exists:eixos,id',
            'responsavel_id' => 'required|exists:users,id',
            'indicador_id'   => 'nullable|exists:indicadores,id', 
            'objetivo'       => 'required|string',
            'descricao_acao' => 'required|string',
            'meta'           => 'required|string',
            'bienio'         => 'required|string',
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
            'eixos.required'          => 'Selecione pelo menos um eixo estratégico.',
            'eixos.array'             => 'O formato dos eixos selecionados é inválido.',
            'eixos.min'               => 'Selecione pelo menos um eixo estratégico.',
            'eixos.*.exists'          => 'Um ou mais eixos selecionados são inválidos.',
            'responsavel_id.required' => 'O responsável é obrigatório.',
            'responsavel_id.exists'   => 'O usuário responsável selecionado é inválido.',
            'indicador_id.exists'     => 'O indicador selecionado é inválido.',
            'objetivo.required'       => 'O objetivo é obrigatório.',
            'descricao_acao.required' => 'A descrição da ação é obrigatória.',
            'meta.required'           => 'O campo meta é obrigatório.',
            'meta.string'             => 'A meta deve ser um texto válido.',
            'bienio.required'         => 'O campo biênio é obrigatório.',
            'bienio.string'           => 'O biênio deve ser um texto válido.',
            'prazo_execucao.date'     => 'O prazo de execução deve ser uma data válida.',
        ];
    }
}