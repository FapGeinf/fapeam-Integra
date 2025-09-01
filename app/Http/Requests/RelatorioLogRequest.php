<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelatorioLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'created_at' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'created_at.required' => 'Por favor, você não pode deixar esse campo vazio',
            'created_at.date' => 'Por favor, selecione uma data válida',
        ];
    }
}
