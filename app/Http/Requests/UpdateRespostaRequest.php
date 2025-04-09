<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRespostaRequest extends FormRequest
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
            'respostaRisco' => 'nullable|string|max:5000',
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
            'statusMonitoramento' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'respostaRisco.string' => 'A resposta deve ser um texto válido.',
            'respostaRisco.max' => 'A resposta não pode ter mais de 5000 caracteres.',

            'anexo.file' => 'O anexo deve ser um arquivo válido.',
            'anexo.mimes' => 'O anexo deve estar no formato JPG, PNG ou PDF.',
            'anexo.max' => 'O anexo não pode ser maior que 100MB.',
        ];
    }

}
