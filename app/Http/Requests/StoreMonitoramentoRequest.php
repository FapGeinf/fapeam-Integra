<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonitoramentoRequest extends FormRequest
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
            'monitoramentos' => 'required|array',
            'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
            'monitoramentos.*.statusMonitoramento' => 'max:9000',
            'monitoramentos.*.inicioMonitoramento' => 'required|date',
            'monitoramentos.*.fimMonitoramento' => 'nullable|date|after_or_equal:monitoramentos.*.inicioMonitoramento',
            'monitoramentos.*.isContinuo' => 'required|boolean',
            'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'monitoramentos.required' => 'É necessário adicionar pelo menos um monitoramento.',
            'monitoramentos.*.monitoramentoControleSugerido.max' => 'O controle sugerido deve ter no máximo 9000 caracteres.',
            'monitoramentos.*.statusMonitoramento.max' => 'O status do monitoramento deve ter no máximo 9000 caracteres.',
            'monitoramentos.*.inicioMonitoramento.required' => 'A data de início do monitoramento é obrigatória.',
            'monitoramentos.*.inicioMonitoramento.date' => 'A data de início do monitoramento deve ser válida.',
            'monitoramentos.*.fimMonitoramento.date' => 'A data de fim do monitoramento deve ser válida.',
            'monitoramentos.*.fimMonitoramento.after_or_equal' => 'A data de fim do monitoramento deve ser igual ou posterior à data de início.',
            'monitoramentos.*.isContinuo.required' => 'O campo de monitoramento contínuo é obrigatório.',
            'monitoramentos.*.isContinuo.boolean' => 'O campo de monitoramento contínuo deve ser verdadeiro ou falso.',
            'monitoramentos.*.anexoMonitoramento.file' => 'O anexo do monitoramento deve ser um arquivo.',
            'monitoramentos.*.anexoMonitoramento.mimes' => 'O anexo deve estar nos formatos: PDF, DOC, DOCX, JPG ou PNG.',
            'monitoramentos.*.anexoMonitoramento.max' => 'O anexo não pode ultrapassar 50MB.',
        ];
    }
}
