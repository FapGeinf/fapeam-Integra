<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiscoRequest extends FormRequest
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
            'responsavelRisco' => 'required',
            'riscoEvento' => 'max:9000',
            'riscoCausa' => 'max:9000',
            'riscoConsequencia' => 'max:9000',
            'riscoAno' => 'required',
            'probabilidade' => 'required|integer',
            'impacto' => 'required|integer',
            'nivel_de_risco' => 'required|integer',
            'unidadeId' => 'required|exists:unidades,id',
            'monitoramentos' => 'required|array|min:1',
            'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
            'monitoramentos.*.statusMonitoramento' => 'required|string',
            'monitoramentos.*.inicioMonitoramento' => 'required|date',
            'monitoramentos.*.fimMonitoramento' => 'nullable|date|after:monitoramentos.*.inicioMonitoramento',
            'monitoramentos.*.isContinuo' => 'required|boolean',
            'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
        ];
    }

    public function messages()
    {
        return [
            'responsavelRisco.required' => 'O campo responsável pelo risco é obrigatório.',
            'riscoEvento.max' => 'O evento de risco deve ter no máximo 9000 caracteres.',
            'riscoCausa.max' => 'A causa do risco deve ter no máximo 9000 caracteres.',
            'riscoConsequencia.max' => 'A consequência do risco deve ter no máximo 9000 caracteres.',
            'riscoAno.required' => 'O ano do risco é obrigatório.',

            'probabilidade.required' => 'A probabilidade é obrigatória.',
            'probabilidade.integer' => 'A probabilidade deve ser um número inteiro.',

            'impacto.required' => 'O impacto é obrigatório.',
            'impacto.integer' => 'O impacto deve ser um número inteiro.',

            'nivel_de_risco.required' => 'O nível de risco é obrigatório.',
            'nivel_de_risco.integer' => 'O nível de risco deve ser um número inteiro.',

            'unidadeId.required' => 'A unidade é obrigatória.',
            'unidadeId.exists' => 'A unidade selecionada é inválida.',

            'monitoramentos.required' => 'É necessário informar ao menos um monitoramento.',
            'monitoramentos.array' => 'Os monitoramentos devem estar em formato de lista.',
            'monitoramentos.min' => 'É necessário informar ao menos um monitoramento.',

            'monitoramentos.*.monitoramentoControleSugerido.max' => 'O controle sugerido deve ter no máximo 9000 caracteres.',
            'monitoramentos.*.statusMonitoramento.required' => 'O status do monitoramento é obrigatório.',
            'monitoramentos.*.statusMonitoramento.string' => 'O status do monitoramento deve ser uma string.',

            'monitoramentos.*.inicioMonitoramento.required' => 'A data de início do monitoramento é obrigatória.',
            'monitoramentos.*.inicioMonitoramento.date' => 'A data de início do monitoramento deve ser uma data válida.',

            'monitoramentos.*.fimMonitoramento.date' => 'A data de fim do monitoramento deve ser uma data válida.',
            'monitoramentos.*.fimMonitoramento.after' => 'A data de fim do monitoramento deve ser posterior à data de início.',

            'monitoramentos.*.isContinuo.required' => 'O campo "É contínuo?" é obrigatório.',
            'monitoramentos.*.isContinuo.boolean' => 'O campo "É contínuo?" deve ser verdadeiro ou falso.',

            'monitoramentos.*.anexoMonitoramento.file' => 'O anexo deve ser um arquivo.',
            'monitoramentos.*.anexoMonitoramento.mimes' => 'O anexo deve ser um arquivo do tipo: jpeg, png, ou pdf.',
            'monitoramentos.*.anexoMonitoramento.max' => 'O anexo não pode ter mais que 50 MB.',
        ];

    }
}
