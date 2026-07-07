<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
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
            'unidadeNome' => 'required|string|max:255',
            'unidadeSigla' => 'required|string|max:10',
            'unidadeEmail' => 'required|email|max:255',
            'unidadeTipoFK' => 'required|exists:unidade_tipos,id',
        ];
    }
}
