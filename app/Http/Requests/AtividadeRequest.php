<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Publico;
use App\Models\Canal;

class AtividadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'eixo_ids' => 'nullable|array',
            'eixo_ids.*' => 'exists:eixos,id',
						'responsavel' => 'nullable|string|max:255',
            'atividade_descricao' => 'required|string',
            'objetivo' => 'required|string',
            'publico_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== 'outros' && !Publico::where('id', $value)->exists()) {
                        $fail('O público selecionado não está cadastrado. Por favor, escolha um público válido.');
                    }
                },
            ],
            'novo_publico' => 'nullable|string|max:255',
            'tipo_evento' => 'nullable|string|max:255',
            'canal_id' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $canalId) {
                        if ($canalId !== 'outros' && !Canal::where('id', $canalId)->exists()) {
                            $fail('O canal de divulgação escolhido não é válido.');
                            break;
                        }
                    }
                },
            ],
            'outro_canal' => 'nullable|string|max:255',
            'data_prevista' => 'nullable|date',
            'data_realizada' => 'nullable|date',
            'meta' => 'nullable|integer|min:0',
            'realizado' => 'nullable|integer|min:0',
            'medida_id' => 'nullable|exists:medida_tipos,id',
        ];
    }

    /**
     * Obtenha as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'eixo_ids.required' => 'Por favor, selecione pelo menos um eixo para continuar.',
            'eixo_ids.array' => 'Os eixos devem estar no formato correto.',
            'eixo_ids.*.exists' => 'Alguns dos eixos selecionados não existem. Verifique sua seleção.',
						// 'responsavel.required' => 'Toda atividade deve possuir um responsável',
						'responsavel.max' => 'O nome do responsável não pode ter mais que 255 caracteres',
						'atividade_descricao.required' => 'Não se esqueça de informar a descrição da atividade.',
            'atividade_descricao.string' => 'A descrição da atividade deve ser um texto simples.',
            'objetivo.required' => 'Por favor, informe o objetivo da atividade.',
            'objetivo.string' => 'O objetivo deve ser descrito em texto.',
            'novo_publico.string' => 'O campo para público personalizado deve conter texto.',
            'novo_publico.max' => 'O nome do público não pode ter mais que 255 caracteres.',
            // 'tipo_evento.required' => 'É necessário informar o tipo de evento.',
            // 'tipo_evento.string' => 'O tipo de evento deve ser descrito em texto.',
            'tipo_evento.max' => 'O tipo de evento não pode ter mais que 255 caracteres.',
            // 'canal_id.required' => 'Por favor, selecione pelo menos um canal de divulgação.',
            'canal_id.array' => 'Os canais de divulgação devem ser fornecidos como uma lista.',
            'canal_id.exists' => 'Alguns dos canais de divulgação escolhidos não são válidos.',
            // 'data_prevista.required' => 'Informe a data prevista para o evento.',
            'data_prevista.date' => 'A data prevista deve estar no formato correto.',
            // 'data_realizada.required' => 'Informe a data em que o evento foi realizado.',
            'data_realizada.date' => 'A data realizada deve estar no formato correto.',
            // 'meta.required' => 'A meta não pode ser deixada em branco.',
            'meta.integer' => 'A meta deve ser um número inteiro.',
            'meta.min' => 'A meta deve ser pelo menos 0.',
            // 'realizado.required' => 'Informe o número de realizações.',
            'realizado.integer' => 'O campo "Realizado" deve conter um número inteiro.',
            'realizado.min' => 'O número de realizações deve ser pelo menos 0.',
            'medida_id.exists' => 'O tipo de medida selecionado não é válido. Por favor, revise.',
        ];
    }
}
