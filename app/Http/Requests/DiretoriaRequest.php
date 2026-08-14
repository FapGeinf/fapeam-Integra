<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiretoriaRequest extends FormRequest
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
            'diretoriaNome' => 'required|string|max:255',
            'diretoriaSigla' => 'required|string|max:10',
            'diretor' => 'nullable|exists:users,id',
        ];
    }
}
