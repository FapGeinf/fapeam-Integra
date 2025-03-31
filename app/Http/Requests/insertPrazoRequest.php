<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class insertPrazoRequest extends FormRequest
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
            'data' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'data.required' => 'O campo data é obrigatório.',
            'data.date' => 'A data informada não é válida. Insira uma data no formato correto.',
        ];
    }

}
