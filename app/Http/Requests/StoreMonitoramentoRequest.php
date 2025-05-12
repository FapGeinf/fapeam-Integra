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
            'monitoramentos.*.fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
            'monitoramentos.*.isContinuo' => 'required|boolean',
            'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'monitoramentos.required' => 'É necessário informar ao menos um monitoramento.',
            'monitoramentos.array' => 'Os monitoramentos devem estar em formato de lista.',

            'monitoramentos.*.monitoramentoControleSugerido.max' => 'O controle sugerido deve ter no máximo 9000 caracteres.',

            'monitoramentos.*.statusMonitoramento.max' => 'O status do monitoramento deve ter no máximo 9000 caracteres.',

            'monitoramentos.*.inicioMonitoramento.required' => 'A data de início do monitoramento é obrigatória.',
            'monitoramentos.*.inicioMonitoramento.date' => 'A data de início do monitoramento deve ser uma data válida.',

            'monitoramentos.*.fimMonitoramento.date' => 'A data de fim do monitoramento deve ser uma data válida.',
            'monitoramentos.*.fimMonitoramento.after_or_equal' => 'A data de fim do monitoramento deve ser igual ou posterior à data de início.',

            'monitoramentos.*.isContinuo.required' => 'O campo "É contínuo?" é obrigatório.',
            'monitoramentos.*.isContinuo.boolean' => 'O campo "É contínuo?" deve ser verdadeiro ou falso.',

            'monitoramentos.*.anexoMonitoramento.file' => 'O anexo deve ser um arquivo válido.',
            'monitoramentos.*.anexoMonitoramento.mimes' => 'O anexo deve ser do tipo: pdf, doc, docx, jpg ou png.',
            'monitoramentos.*.anexoMonitoramento.max' => 'O anexo não pode exceder 50 MB.',
        ];
    }

}
