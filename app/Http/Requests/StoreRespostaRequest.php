<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespostaRequest extends FormRequest
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
            'statusMonitoramento' => 'required|string|in:NÃO IMPLEMENTADA,EM IMPLEMENTAÇÃO,IMPLEMENTADA PARCIALMENTE,IMPLEMENTADA',
            'respostaRisco' => 'required|string|max:5000',
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400'
        ];
    }

    public function messages()
    {
        return [
            'statusMonitoramento.required' => 'O campo status do monitoramento é obrigatório.',
            'statusMonitoramento.string' => 'O status do monitoramento deve ser texto.',
            'statusMonitoramento.in' => 'O status do monitoramento selecionado é inválido.',
            'respostaRisco.required' => 'O campo resposta ao risco é obrigatório.',
            'respostaRisco.string' => 'A resposta ao risco deve ser um texto.',
            'respostaRisco.max' => 'A resposta ao risco não pode exceder 5000 caracteres.',
            'anexo.file' => 'O anexo deve ser um arquivo válido.',
            'anexo.mimes' => 'O anexo deve ser um arquivo do tipo: jpg, png ou pdf.',
            'anexo.max' => 'O anexo não pode exceder 100 MB.',
        ];
    }


}
