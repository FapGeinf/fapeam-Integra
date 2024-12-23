<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Models\Eixo;
use App\Models\Publico;
use App\Models\Canal;
use App\Models\MedidaTipo;

class AtividadeController extends Controller
{
    protected $atividade;
    protected $eixo;

    public function __construct(Atividade $atividade, Eixo $eixo)
    {
        $this->atividade = $atividade;
        $this->eixo = $eixo;
    }

    private function validateRules(Request $request)
    {
        return $request->validate([
            'eixo_ids' => 'required|array',
            'eixo_ids.*' => 'exists:eixos,id',
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
            'tipo_evento' => 'required|string|max:255',
            'canal_id' => 'required|exists:canais,id',
            'data_prevista' => 'required|date',
            'data_realizada' => 'required|date',
            'meta' => 'required|integer|min:0',
            'realizado' => 'required|integer|min:0',
            'medida_id' => 'nullable|exists:medida_tipos,id',
        ], [
            'eixo_ids.required' => 'Por favor, selecione pelo menos um eixo para continuar.',
            'eixo_ids.array' => 'Os eixos devem estar no formato correto.',
            'eixo_ids.*.exists' => 'Alguns dos eixos selecionados não existem. Verifique sua seleção.',
            'atividade_descricao.required' => 'Não se esqueça de informar a descrição da atividade.',
            'atividade_descricao.string' => 'A descrição da atividade deve ser um texto simples.',
            'objetivo.required' => 'Por favor, informe o objetivo da atividade.',
            'objetivo.string' => 'O objetivo deve ser descrito em texto.',
            'novo_publico.string' => 'O campo para público personalizado deve conter texto.',
            'novo_publico.max' => 'O nome do público não pode ter mais que 255 caracteres.',
            'tipo_evento.required' => 'É necessário informar o tipo de evento.',
            'tipo_evento.string' => 'O tipo de evento deve ser descrito em texto.',
            'tipo_evento.max' => 'O tipo de evento não pode ter mais que 255 caracteres.',
            'canal_id.required' => 'Por favor, selecione um canal de divulgação.',
            'canal_id.exists' => 'O canal de divulgação escolhido não é válido.',
            'data_prevista.required' => 'Informe a data prevista para o evento.',
            'data_prevista.date' => 'A data prevista deve estar no formato correto.',
            'data_realizada.required' => 'Informe a data em que o evento foi realizado.',
            'data_realizada.date' => 'A data realizada deve estar no formato correto.',
            'meta.required' => 'A meta não pode ser deixada em branco.',
            'meta.integer' => 'A meta deve ser um número inteiro.',
            'meta.min' => 'A meta deve ser pelo menos 0.',
            'realizado.required' => 'Informe o número de realizações.',
            'realizado.integer' => 'O campo "Realizado" deve conter um número inteiro.',
            'realizado.min' => 'O número de realizações deve ser pelo menos 0.',
            'medida_id.exists' => 'O tipo de medida selecionado não é válido. Por favor, revise.',
        ]);
    }
    

    public function index(Request $request)
    {
        $eixo_id = $request->get('eixo_id');

        if ($eixo_id && in_array($eixo_id, [1, 2, 3, 4, 5, 6, 7])) {
            $atividades = $this->atividade->whereHas('eixos', function ($query) use ($eixo_id) {
                $query->where('eixo_id', $eixo_id);
            })->with(['publico', 'canal', 'medida'])->get();
        } else {
            $atividades = $this->atividade->all();
        }

        return view('atividades.index', ['atividades' => $atividades]);
    }


    public function showAtividade($id)
    {
        $atividade = $this->atividade->findOrFail($id);
        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $eixos = $this->eixo->all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        return view('atividades.createAtividade', ['eixos' => $eixos, 'publicos' => $publicos, "canais" => $canais, 'medidas' => $medidas]);
    }

    public function storeAtividade(Request $request)
    {
        $validatedData = $this->validateRules($request);

        try {
            if ($request->input('publico_id') === 'outros' && $request->filled('novo_publico')) {
                $novoPublico = Publico::create([
                    'nome' => $request->input('novo_publico'),
                ]);

                $validatedData['publico_id'] = $novoPublico->id;
            }

            $atividade = $this->atividade->create($validatedData);

            if ($request->has('eixo_ids')) {
                $atividade->eixos()->attach($request->eixo_ids);
            }

            return redirect()->route('atividades.index')->with('success', 'Atividade criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a atividade. Por favor, tente novamente mais tarde.');
        }
    }



    public function editAtividade($id)
    {
        $eixos = $this->eixo->all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        $atividade = $this->atividade->findOrFail($id);

        if (!$atividade) {
            return redirect()->back()->with('error', 'Não foi encontrada a atividade selecionada no sistema.');
        }

        return view('atividades.editAtividade', ['eixos' => $eixos, 'atividade' => $atividade, 'publicos' => $publicos, 'canais' => $canais, 'medidas' => $medidas]);
    }

    public function updateAtividade(Request $request, $id)
    {
        $validatedData = $this->validateRules($request);

        try {
            if ($request->input('publico_id') === 'outros' && $request->filled('novo_publico')) {
                $novoPublico = Publico::create(['nome' => $request->input('novo_publico')]);
                $validatedData['publico_id'] = $novoPublico->id;
            }

            $atividade = $this->atividade->findOrFail($id);
            $atividade->update($validatedData);


            if ($request->has('eixo_ids')) {
                $atividade->eixos()->sync($request->eixo_ids);
            }

            return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a atividade. Por favor, tente novamente mais tarde.');
        }
    }



    public function deleteAtividade($id)
    {
        try {
            $atividade = $this->atividade->findOrFail($id);
            $atividade->delete();
            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}
