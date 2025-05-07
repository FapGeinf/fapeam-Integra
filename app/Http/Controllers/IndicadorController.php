<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use App\Services\IndicadorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Eixo;

class IndicadorController extends Controller
{
    protected $log;
    protected $indicadorService;

    public function __construct(LogService $log, IndicadorService $indicadorService)
    {
        $this->log = $log;
        $this->indicadorService = $indicadorService;
    }

    public function index(Request $request)
    {
        try {
            $data = ['eixo_id' => $request->get('eixo_id')];
            $indicadores = $this->indicadorService->indexLogs($data);

            if (Auth::check()) {
                $username = Auth::user()->name;
                $eixoNome = $data['eixo_id'] && $indicadores->isNotEmpty()
                    ? $indicadores->first()->eixo->nome
                    : 'todos os eixos';

                $this->log->insertLog([
                    'acao' => 'Acesso',
                    'descricao' => "O usuário de nome $username está acessando a index dos indicadores do eixo $eixoNome",
                    'user_id' => Auth::user()->id
                ]);
            }

            return view('indicadores.index', compact('indicadores'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Erro ao carregar indicadores: ' . $th->getMessage()]);
        }
    }

    public function create()
    {
        $eixos = Eixo::all();

        if (Auth::check()) {
            $username = Auth::user()->name;

            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário de nome $username está acessando a página de inserção de indicadores",
                'user_id' => Auth::user()->id
            ]);
        }

        return view('indicadores.create', compact('eixos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomeIndicador' => 'nullable|string|max:255',
                'descricaoIndicador' => 'nullable|string',
                'eixo_fk' => 'nullable|exists:eixos,id',
            ]);

            $indicador = $this->indicadorService->insertIndicador($request->only(['nomeIndicador', 'descricaoIndicador', 'eixo_fk']));

            if (Auth::check()) {
                $username = Auth::user()->name;

                $this->log->insertLog([
                    'acao' => 'Inserção',
                    'descricao' => "O usuário de nome $username está inserindo um novo indicador do eixo {$indicador->eixo->nome}",
                    'user_id' => Auth::user()->id
                ]);
            }

            return redirect()->route('indicadores.index')->with('success', 'Indicador criado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Erro ao criar indicador: ' . $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $indicador = $this->indicadorService->getIndicadorById($id);
            $eixos = Eixo::all();

            if (Auth::check()) {
                $username = Auth::user()->name;

                $this->log->insertLog([
                    'acao' => 'Acesso',
                    'descricao' => "O usuário de nome $username está acessando a página de edição do indicador de ID $id do eixo {$indicador->eixo->nome}",
                    'user_id' => Auth::user()->id
                ]);
            }

            return view('indicadores.edit', compact('indicador', 'eixos'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Erro ao carregar indicador: ' . $th->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nomeIndicador' => 'nullable|string|max:255',
                'descricaoIndicador' => 'nullable|string|max:255',
                'eixo_fk' => 'nullable|exists:eixos,id',
            ]);

            $this->indicadorService->updateIndicador($id, $request->only(['nomeIndicador', 'descricaoIndicador', 'eixo_fk']));
            $indicador = $this->indicadorService->getIndicadorById($id);

            if (Auth::check()) {
                $username = Auth::user()->name;

                $this->log->insertLog([
                    'acao' => 'Atualização',
                    'descricao' => "O usuário de nome $username está atualizando o indicador de ID $id e eixo {$indicador->eixo->nome}",
                    'user_id' => Auth::user()->id
                ]);
            }

            return redirect()->route('indicadores.index')->with('success', 'Indicador atualizado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar indicador: ' . $th->getMessage()]);
        }
    }
}
