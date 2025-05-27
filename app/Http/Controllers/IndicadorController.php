<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicadorRequest;
use App\Services\EixoService;
use App\Services\LogService;
use App\Services\IndicadorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Eixo;
use Log;

class IndicadorController extends Controller
{
    protected $log;
    protected $indicadorService;

    protected $eixo;

    public function __construct(LogService $log, IndicadorService $indicadorService, EixoService $eixo)
    {
        $this->log = $log;
        $this->indicadorService = $indicadorService;
        $this->eixo = $eixo;
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
            Log::error('Erro ao carregar indicadores: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Erro ao carregar indicadores.']);
        }
    }

    public function create()
    {
           $eixos = $this->eixo->getAllEixosOrderbyNome();
           return view('indicadores.create',compact('eixos'));
    }

    public function store(IndicadorRequest $request)
    {
        try {
            $request->validated();

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
            Log::error('Erro ao criar indicador: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Erro ao criar indicador.']);
        }
    }

    public function edit($id)
    {
        try {
            $indicador = $this->indicadorService->getIndicadorById($id);
            $eixos = $this->eixo->getAllEixos();

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
            Log::error('Erro ao carregar indicador: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Erro ao carregar indicador.']);
        }
    }

    public function update(IndicadorRequest $request, $id)
    {
        try {
            $request->validated();

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
            Log::error('Erro ao atualizar indicador: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar indicador.']);
        }
    }
}
