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
            'respostaRisco' => 'required|string|max:5000',
            'statusMonitoramento' => 'required|integer', // Adicionado aqui
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400'
        ];
    }

    public function messages()
    {
        return [
            'respostaRisco.required' => 'O campo "Resposta do Risco" é obrigatório.',
            'respostaRisco.string' => 'O campo "Resposta do Risco" deve ser um texto válido.',
            'respostaRisco.max' => 'O campo "Resposta do Risco" não pode exceder 5000 caracteres.',

            'statusMonitoramento.required' => 'O campo "Status do Monitoramento" é obrigatório.',
            'statusMonitoramento.integer' => 'O campo "Status do Monitoramento" deve ser um número inteiro.',

            'anexo.file' => 'O campo "Anexo" deve ser um arquivo.',
            'anexo.mimes' => 'O campo "Anexo" deve ser um arquivo do tipo: jpg, png, pdf.',
            'anexo.max' => 'O campo "Anexo" não pode ultrapassar 100MB.',
        ];
    }

}
