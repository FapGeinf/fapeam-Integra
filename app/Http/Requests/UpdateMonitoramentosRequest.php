<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonitoramentosRequest extends FormRequest
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
            'monitoramentoControleSugerido' => 'nullable|string',
            'statusMonitoramento' => 'nullable|string',
            'isContinuo' => 'nullable|boolean',
            'inicioMonitoramento' => 'nullable|date',
            'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
        ];
    }

    public function messages()
    {
        return [
            'monitoramentoControleSugerido.string' => 'O controle sugerido deve ser um texto válido.',
            
            'statusMonitoramento.string' => 'O status do monitoramento deve ser um texto válido.',
            
            'isContinuo.boolean' => 'O campo de monitoramento contínuo deve ser verdadeiro ou falso.',
            
            'inicioMonitoramento.date' => 'A data de início do monitoramento deve ser válida.',
            
            'fimMonitoramento.date' => 'A data de fim do monitoramento deve ser válida.',
            'fimMonitoramento.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
        ];
    }
}
