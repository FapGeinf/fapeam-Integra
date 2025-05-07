<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertCanalRequest extends FormRequest
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
              'nome' => 'max:255'
        ];
    }

    public function messages()
    {
           return [
             'nome.max' => 'O nome do canal não pode ter mais de 255 caracteres'
           ];
    }
}
