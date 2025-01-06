<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Models\Eixo;
use App\Models\Publico;
use App\Models\Canal;
use App\Models\MedidaTipo;
use Illuminate\Support\Facades\Log;

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
            'canal_id' => [
                'required',
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
            'canal_id.required' => 'Por favor, selecione pelo menos um canal de divulgação.',
            'canal_id.array' => 'Os canais de divulgação devem ser fornecidos como uma lista.',
            'canal_id.exists' => 'Alguns dos canais de divulgação escolhidos não são válidos.',
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
            })->with(['publico', 'canais', 'medida'])->get();
        } else {
            $atividades = $this->atividade->with(['publico', 'canais', 'medida'])->get();
        }

        return view('atividades.index', ['atividades' => $atividades]);
    }

    public function createCanal(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|max:255'
            ]);

            if (Canal::where('nome', $request->input('nome'))->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'O canal já existe.'
                ], 400);
            }

            $canal = Canal::create([
                'nome' => $request->input('nome')
            ]);

            return response()->json([
                'success' => true,
                'canal' => $canal
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erro ao criar canal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao tentar criar o canal. Tente novamente mais tarde.'
            ], 500);
        }
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
        Log::info('Dados recebidos para criação da atividade:', $request->all());

        try {
            $validatedData = $this->validateRules($request);

            if ($request->input('publico_id') === 'outros' && $request->filled('novo_publico')) {
                Log::info('Criando novo público', ['nome' => $request->input('novo_publico')]);

                $novoPublico = Publico::create([
                    'nome' => $request->input('novo_publico'),
                ]);

                $validatedData['publico_id'] = $novoPublico->id;
                Log::info('Novo público criado com sucesso:', ['id' => $novoPublico->id]);
            }


            Log::info('Criando a atividade', ['dados' => $validatedData]);

            $atividade = $this->atividade->create([
                'atividade_descricao' => $validatedData['atividade_descricao'],
                'objetivo' => $validatedData['objetivo'],
                'publico_id' => $validatedData['publico_id'],
                'tipo_evento' => $validatedData['tipo_evento'],
                'data_prevista' => $validatedData['data_prevista'],
                'data_realizada' => $validatedData['data_realizada'],
                'meta' => $validatedData['meta'],
                'realizado' => $validatedData['realizado'],
                'medida_id' => $validatedData['medida_id'],
            ]);

            if ($request->has('eixo_ids')) {
                Log::info('Associando eixos à atividade', ['eixos' => $request->eixo_ids]);
                $atividade->eixos()->attach($request->eixo_ids);
            }

            if ($request->has('canal_id')) {
                Log::info('Associando canais à atividade', ['canais' => $request->canal_id]);
                $atividade->canais()->attach($validatedData['canal_id']);
            }

            Log::info('Atividade criada com sucesso', ['atividade_id' => $atividade->id]);

            return redirect()->route('atividades.index')->with('success', 'Atividade criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao salvar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

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
        Log::info('Dados recebidos para atualização da atividade:', $request->all());

        try {
         
            $validatedData = $this->validateRules($request);

           
            if ($request->input('publico_id') === 'outros' && $request->filled('novo_publico')) {
                Log::info('Criando novo público', ['nome' => $request->input('novo_publico')]);

                $novoPublico = Publico::create(['nome' => $request->input('novo_publico')]);
                $validatedData['publico_id'] = $novoPublico->id;
                Log::info('Novo público criado com sucesso:', ['id' => $novoPublico->id]);
            }

           
            $atividade = $this->atividade->findOrFail($id);

            Log::info('Atualizando a atividade', ['dados' => $validatedData]);

         
            $atividade->update([
                'atividade_descricao' => $validatedData['atividade_descricao'],
                'objetivo' => $validatedData['objetivo'],
                'publico_id' => $validatedData['publico_id'],
                'tipo_evento' => $validatedData['tipo_evento'],
                'data_prevista' => $validatedData['data_prevista'],
                'data_realizada' => $validatedData['data_realizada'],
                'meta' => $validatedData['meta'],
                'realizado' => $validatedData['realizado'],
                'medida_id' => $validatedData['medida_id'],
            ]);

          
            if ($request->has('eixo_ids')) {
                Log::info('Associando eixos à atividade', ['eixos' => $request->eixo_ids]);
                $atividade->eixos()->sync($request->eixo_ids);
            }

            if ($request->has('canal_id')) {
                Log::info('Associando canais à atividade', ['canais' => $request->canal_id]);
                $atividade->canais()->sync($request->canal_id);  
            }

            Log::info('Atividade atualizada com sucesso', ['atividade_id' => $atividade->id]);

            return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

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