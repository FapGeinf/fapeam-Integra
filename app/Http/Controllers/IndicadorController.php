<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicadorRequest;
use App\Services\EixoService;
use App\Services\IndicadorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IndicadorController extends Controller
{
    protected $indicadorService;
    protected $eixo;

    public function __construct(IndicadorService $indicadorService, EixoService $eixo)
    {
        $this->indicadorService = $indicadorService;
        $this->eixo = $eixo;
    }

    public function index(Request $request)
    {
        try {
            $data = ['eixo_id' => $request->get('eixo_id')];
            $indicadores = $this->indicadorService->indexLogs($data);
            return view('indicadores.index', compact('indicadores'));
        } catch (\Throwable $th) {
            Log::error('Erro ao carregar indicadores: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Erro ao carregar indicadores.']);
        }
    }

    public function create()
    {
        try {
            $eixos = $this->eixo->getAllEixosOrderbyNome();
            return view('indicadores.create', compact('eixos'));
        } catch (Exception $e) {
            Log::error('Houve um erro ao carregar o formulário de inserção de indicadores', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro ao carregar o formulário de inserção de indicadores');
        }
    }

    public function store(IndicadorRequest $request)
    {
        try {
            $request->validated();

            $indicador = $this->indicadorService->insertIndicador($request->only(['nomeIndicador', 'descricaoIndicador', 'eixo_fk']));

            Log::info("Inserção de Indicador realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'indicador_id' => $indicador->id ?? null,
                'eixo' => $indicador->eixo->nome ?? null,
            ]);

            return redirect()->route('indicadores.index')->with('success', 'Indicador criado com sucesso!');
        } catch (\Throwable $th) {
            Log::error('Erro ao criar indicador: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao salvar: verifique os campos preenchidos.');
        }
    }

    public function edit($id)
    {
        try {
            $indicador = $this->indicadorService->getIndicadorById($id);
            $eixos = $this->eixo->getAllEixos();
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

            Log::info("Atualização de Indicador realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'indicador_id' => $id,
                'eixo' => $indicador->eixo->nome ?? null,
            ]);

            return redirect()->route('indicadores.index')->with('success', 'Indicador atualizado com sucesso!');
        } catch (\Throwable $th) {
            Log::error('Erro ao atualizar indicador: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()
                ->withInput() 
                ->with('error', 'Erro ao atualizar: verifique os campos preenchidos.');
        }
    }
}