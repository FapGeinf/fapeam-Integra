<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoRequest extends FormRequest
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
            'ano' => 'required|integer',
            'tipo_id' => 'required|exists:tipos_documentos,id',
            'path' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'ano.required' => 'O campo Ano é obrigatório.',
            'ano.integer' => 'O campo Ano deve ser um número.',
            'tipo_id.required' => 'Por favor, selecione um tipo de documento.',
            'tipo_id.exists' => 'Por favor, selecione uma opção válida dos tipos.',
            'path.file' => 'O campo de anexo deve ser um arquivo.',
            'path.mimes' => 'O arquivo deve ser do tipo: pdf, doc, docx, zip, png, jpg ou jpeg.',
        ];
    }
}
