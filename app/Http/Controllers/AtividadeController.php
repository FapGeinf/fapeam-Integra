<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\Eixo;
use App\Models\Publico;
use App\Models\Canal;
use App\Models\MedidaTipo;
use App\Models\Indicador;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;
use Auth;

class AtividadeController extends Controller
{
    protected $atividade;
    protected $eixo;

    protected $log;

    public function __construct(Atividade $atividade, Eixo $eixo, LogService $log)
    {
        $this->atividade = $atividade;
        $this->eixo = $eixo;
        $this->log = $log;
    }

    public function index(Request $request)
    {
        $eixo_id = $request->get('eixo_id');
        $eixoNome = null;

        if ($eixo_id && in_array($eixo_id, [1, 2, 3, 4, 5, 6, 7])) {
            $eixo = Eixo::find($eixo_id);
            $eixoNome = $eixo ? $eixo->nome : null;

            $atividades = $this->atividade->whereHas('eixos', function ($query) use ($eixo_id) {
                $query->where('eixo_id', $eixo_id);
            })->with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        } elseif ($eixo_id == 8) {
            $atividades = $this->atividade->with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        }

        $publicos = Publico::all();
        $canais = Canal::all();

        $username = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuário $username acessou a pagina de atividades do eixo $eixoNome",
            'user_id' => Auth::user()->id
        ]);

        return view('atividades.index', [
            'atividades' => $atividades,
            'eixoNome' => $eixoNome,
            'eixo_id' => $eixo_id,
            'publicos' => $publicos,
            'canais' => $canais
        ]);
    }


    public function createCanal(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'max:255'
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
        $username = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuário $username acessou a página da Atividade com id $id e eixo {$atividade->eixo->nome}",
            'user_id' => Auth::user()->id
        ]);
        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $eixos = $this->eixo->all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        $indicadores = Indicador::all();

        $username = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuário $username acessou a página de inserção de atividades",
            'user_id' => Auth::user()->id
        ]);

        return view('atividades.createAtividade', ['eixos' => $eixos, 'publicos' => $publicos, "canais" => $canais, 'medidas' => $medidas, 'indicadores' => $indicadores]);
    }

    public function storeAtividade(AtividadeRequest $request)
    {
        Log::info('Dados recebidos para criação da atividade:', $request->all());
        try {
            if ($request->input('publico_id') === 'outros' && $request->filled('novo_publico')) {
                Log::info('Criando novo público', ['nome' => $request->input('novo_publico')]);

                $novoPublico = Publico::create([
                    'nome' => $request->input('novo_publico'),
                ]);

                $validatedData = $request->validated();
                $validatedData['publico_id'] = $novoPublico->id;
                Log::info('Novo público criado com sucesso:', ['id' => $novoPublico->id]);
            } else {
                $validatedData = $request->validated();
            }

            Log::info('Criando a atividade', ['dados' => $validatedData]);

            $atividade = $this->atividade->create([
                'atividade_descricao' => $validatedData['atividade_descricao'],
                'objetivo' => $validatedData['objetivo'],
                'responsavel' => $validatedData['responsavel'] ?? null,
                'publico_id' => $validatedData['publico_id'] ?? null,
                'tipo_evento' => $validatedData['tipo_evento'] ?? null,
                'data_prevista' => $validatedData['data_prevista'] ?? null,
                'data_realizada' => $validatedData['data_realizada'] ?? null,
                'meta' => $validatedData['meta'] ?? null,
                'realizado' => $validatedData['realizado'] ?? null,
                'medida_id' => $validatedData['medida_id'] ?? null,
                'justificativa' => $validatedData['justificativa'] ?? null
            ]);

            if ($request->has('eixo_ids')) {
                Log::info('Associando eixos à atividade', ['eixos' => $request->eixo_ids]);
                $atividade->eixos()->attach($request->eixo_ids);
            }

            if ($request->has('canal_id')) {
                Log::info('Associando canais à atividade', ['canais' => $request->canal_id]);
                $atividade->canais()->attach($validatedData['canal_id']);
            }

            if ($request->has('indicador_ids') && !empty($request->indicador_ids)) {
                Log::info('Associando indicadores à atividade', ['indicadores' => $request->indicador_ids]);
                $atividade->indicadores()->attach($request->indicador_ids);
            } else {
                $atividade->indicadores()->detach();
            }


            $eixo_id = $atividade->eixos->first()->id ?? null;

            Log::info('Atividade criada com sucesso', ['atividade_id' => $atividade->id]);


            if (Auth::check()) {
                $user = Auth::user();
                $eixoNome = optional($atividade->eixos->first())->nome ?? 'sem eixo';
            
                $this->log->insertLog([
                    'acao' => 'Inserção',
                    'descricao' => "O usuário {$user->name} inseriu uma nova atividade de eixo {$eixoNome}",
                    'user_id' => $user->id
                ]);
            }

            return redirect()->route('atividades.index', ['eixo_id' => $eixo_id])->with('success', 'Atividade criada com sucesso!');
        } catch (\Exception $e) {
            dd($e);
            Log::error('Erro ao salvar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a atividade. Por favor, tente novamente mais tarde.')->withInput();
        }
    }

    public function editAtividade($id)
    {
        $eixos = $this->eixo->all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        $indicadores = Indicador::all();
        $atividade = $this->atividade->findOrFail($id);

        if(Auth::check()){
           $username = Auth::user()->name;
           $eixoNome = $atividade->eixos->first()->nome;

           $this->log->insertLog([
               'acao' => 'Acesso',
               'descricao' => "O usuário de nome $username está acessando a pagina edição da atividade de id $id e com eixo de $eixoNome",
               'user_id' => Auth::user()->id
           ]);
        }

        if (!$atividade) {
            return redirect()->back()->with('error', 'Não foi encontrada a atividade selecionada no sistema.');
        }

        return view('atividades.editAtividade', ['eixos' => $eixos, 'atividade' => $atividade, 'publicos' => $publicos, 'canais' => $canais, 'medidas' => $medidas, 'indicadores' => $indicadores]);
    }

    public function updateAtividade(AtividadeRequest $request, $id)
    {
        Log::info('Dados recebidos para atualização da atividade:', $request->all());

        try {
            $validatedData = $request->validated();

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
                'responsavel' => $validatedData['responsavel'] ?? null,
                'publico_id' => $validatedData['publico_id'],
                'tipo_evento' => $validatedData['tipo_evento'] ?? null,
                'data_prevista' => $validatedData['data_prevista'] ?? null,
                'data_realizada' => $validatedData['data_realizada'] ?? null,
                'meta' => $validatedData['meta'] ?? null,
                'realizado' => $validatedData['realizado'] ?? null,
                'medida_id' => $validatedData['medida_id'] ?? null,
                'justificativa' => $validatedData['justificativa'] ?? null
            ]);

            if ($request->has('eixo_ids')) {
                Log::info('Associando eixos à atividade', ['eixos' => $request->eixo_ids]);
                $atividade->eixos()->sync($request->eixo_ids);
            }

            if ($request->has('canal_id')) {
                Log::info('Associando canais à atividade', ['canais' => $request->canal_id]);
                $atividade->canais()->sync($request->canal_id);
            }

            if ($request->has('indicador_ids')) {
                Log::info('Associando indicadores à atividade', ['indicadores' => $request->indicador_ids]);
                $atividade->indicadores()->sync($request->indicador_ids);
            } else {
                $atividade->indicadores()->detach();
            }

            $eixo_id = $atividade->eixos->first()->id ?? null;

            if(Auth::check()){
                $username = Auth::user()->name;
                $eixoNome = $atividade->eixos->first()->nome;
     
                $this->log->insertLog([
                    'acao' => 'Atualização',
                    'descricao' => "O usuário de nome $username estar atualizando a atividade de id $id e com eixo de $eixoNome",
                    'user_id' => Auth::user()->id
                ]);
             }

            Log::info('Atividade atualizada com sucesso', ['atividade_id' => $atividade->id]);

            return redirect()->route('atividades.index', ['eixo_id' => $eixo_id])->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a atividade. Por favor, tente novamente mais tarde.')->withInput();
        }
    }


    public function deleteAtividade($id)
    {
        try {
            $atividade = $this->atividade->findOrFail($id);
            $atividade->delete();
            if (Auth::check()) {
                $user = Auth::user();
                $this->log->insertLog([
                    'acao' => 'Inserção',
                    'descricao' => "O usuário {$user->name} excluiu uma atividade de $id do eixo {$atividade->eixos->first()->nome}",
                    'user_id' => $user->id
                ]);
            }
            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}