<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonitoramentoRequest extends FormRequest
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
            'monitoramentoControleSugerido' => 'required|string',
            'statusMonitoramento' => 'required|string',
            'isContinuo' => 'required|boolean',
            'inicioMonitoramento' => 'required|date',
            'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
            'anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
        ];
    }

    public function messages()
    {
        return [
            'monitoramentoControleSugerido.required' => 'O campo controle sugerido é obrigatório.',
            'monitoramentoControleSugerido.string' => 'O campo controle sugerido deve ser um texto.',

            'statusMonitoramento.required' => 'O campo status do monitoramento é obrigatório.',
            'statusMonitoramento.string' => 'O campo status do monitoramento deve ser um texto.',

            'isContinuo.required' => 'O campo "É contínuo?" é obrigatório.',
            'isContinuo.boolean' => 'O campo "É contínuo?" deve ser verdadeiro ou falso.',

            'inicioMonitoramento.required' => 'A data de início do monitoramento é obrigatória.',
            'inicioMonitoramento.date' => 'A data de início do monitoramento deve ser uma data válida.',

            'fimMonitoramento.date' => 'A data de fim do monitoramento deve ser uma data válida.',
            'fimMonitoramento.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',

            'anexoMonitoramento.file' => 'O anexo deve ser um arquivo válido.',
            'anexoMonitoramento.mimes' => 'O anexo deve ser um arquivo do tipo: jpeg, png ou pdf.',
            'anexoMonitoramento.max' => 'O anexo não pode exceder 50 MB.',
        ];
    }

}
