<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadeRequest extends FormRequest
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
            'unidadeNome'   => 'sometimes|required|string|max:255', 
            'unidadeSigla'  => 'sometimes|required|string|max:10', 
            'unidadeEmail'  => 'sometimes|required|email|max:255',
            'unidadeTipoFK' => 'sometimes|required|exists:unidade_tipos,id',
        ];
    }
}