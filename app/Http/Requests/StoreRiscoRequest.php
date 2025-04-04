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
            'riscoEvento.max' => 'O campo risco evento pode ter no máximo 9000 caracteres.',
            'riscoCausa.max' => 'O campo risco causa pode ter no máximo 9000 caracteres.',
            'riscoConsequencia.max' => 'O campo risco consequência pode ter no máximo 9000 caracteres.',
            'riscoAno.required' => 'O campo ano do risco é obrigatório.',
            'nivel_de_risco.required' => 'O campo nível de risco é obrigatório.',
            'nivel_de_risco.integer' => 'O campo nível de risco deve ser um número inteiro.',
            'unidadeId.required' => 'O campo unidade é obrigatório.',
            'unidadeId.exists' => 'A unidade informada não existe.',
            'monitoramentos.required' => 'O campo monitoramentos é obrigatório.',
            'monitoramentos.array' => 'O campo monitoramentos deve ser um array.',
            'monitoramentos.min' => 'É necessário pelo menos um monitoramento.',
            'monitoramentos.*.monitoramentoControleSugerido.max' => 'O campo controle sugerido pode ter no máximo 9000 caracteres.',
            'monitoramentos.*.statusMonitoramento.required' => 'O campo status do monitoramento é obrigatório.',
            'monitoramentos.*.statusMonitoramento.string' => 'O campo status do monitoramento deve ser uma string.',
            'monitoramentos.*.inicioMonitoramento.required' => 'O campo início do monitoramento é obrigatório.',
            'monitoramentos.*.inicioMonitoramento.date' => 'O campo início do monitoramento deve ser uma data válida.',
            'monitoramentos.*.fimMonitoramento.date' => 'O campo fim do monitoramento deve ser uma data válida.',
            'monitoramentos.*.fimMonitoramento.after' => 'O campo fim do monitoramento deve ser uma data posterior ao início do monitoramento.',
            'monitoramentos.*.isContinuo.required' => 'O campo é contínuo é obrigatório.',
            'monitoramentos.*.isContinuo.boolean' => 'O campo é contínuo deve ser verdadeiro ou falso.',
            'monitoramentos.*.anexoMonitoramento.file' => 'O anexo do monitoramento deve ser um arquivo.',
            'monitoramentos.*.anexoMonitoramento.mimes' => 'O anexo do monitoramento deve ser um arquivo dos tipos: jpeg, png, pdf.',
            'monitoramentos.*.anexoMonitoramento.max' => 'O anexo do monitoramento não pode ultrapassar 50MB.'
        ];
    }
}
