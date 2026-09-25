<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoAcaoRequest;
use App\Models\Eixo;
use App\Models\Indicador;
use App\Models\PlanoAcao;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class PlanoAcaoController extends Controller
{
    public function index()
    {
        Log::info('Acessando a listagem de Planos de Ação.');

        $planos = PlanoAcao::with(['eixo', 'responsavel', 'indicador'])
            ->join('eixos', 'plano_acaos.eixo_id', '=', 'eixos.id')
            ->orderBy('eixos.nome')
            ->select('plano_acaos.*')
            ->get();

        return view('plano_acoes.index', ['planos' => $planos]);
    }

    public function create()
    {
        Log::info('Acessando o formulário de cadastro de Plano de Ação.');

        $usuarios = User::with(['unidade'])->orderBy('name')->get();
        $eixos = Eixo::orderBy('nome')->get();
        $indicadores = Indicador::orderBy('nomeIndicador')->get();

        return view('plano_acoes.create', [
            'eixos' => $eixos, 
            'indicadores' => $indicadores, 
            'usuarios' => $usuarios
        ]);
    }

    public function store(PlanoAcaoRequest $request)
    {
        Log::info('Tentando cadastrar um novo Plano de Ação.', ['dados' => $request->validated()]);

        try {
            $planoAcao = PlanoAcao::create($request->validated());
            
            Log::info('Plano de Ação cadastrado com sucesso.', ['id' => $planoAcao->id]);
            return redirect()->route('plano_acoes.index')->with('success', 'Plano de Ação cadastrado com sucesso.');
        
        } catch (QueryException $e) {
            Log::error('Erro de banco de dados ao cadastrar Plano de Ação.', [
                'erro' => $e->getMessage(),
                'dados' => $request->all()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar o Plano de Ação. Verifique os dados e tente novamente.');
        }
    }

    public function show(PlanoAcao $planoAcao)
    {
        Log::info('Visualizando detalhes do Plano de Ação.', ['id' => $planoAcao->id]);

        $planoAcao->load(['eixo', 'responsavel', 'indicador']);
        
        return view('plano_acoes.show', ['planoAcao' => $planoAcao]);
    }

    public function edit(PlanoAcao $planoAcao)
    {
        Log::info('Acessando o formulário de edição do Plano de Ação.', ['id' => $planoAcao->id]);

        $usuarios = User::with(['unidade'])->orderBy('name')->get();
        $eixos = Eixo::orderBy('nome')->get();
        $indicadores = Indicador::orderBy('nomeIndicador')->get();

        return view('plano_acoes.edit', [
            'planoAcao' => $planoAcao,
            'eixos' => $eixos,
            'indicadores' => $indicadores,
            'usuarios' => $usuarios
        ]);
    }

    public function update(PlanoAcaoRequest $request, PlanoAcao $planoAcao)
    {
        Log::info('Tentando atualizar o Plano de Ação.', [
            'id' => $planoAcao->id,
            'dados' => $request->validated()
        ]);

        try {
            $planoAcao->update($request->validated());

            Log::info('Plano de Ação atualizado com sucesso.', ['id' => $planoAcao->id]);
            return redirect()->route('plano_acoes.index')->with('success', 'Plano de Ação atualizado com sucesso.');
        
        } catch (QueryException $e) {
            Log::error('Erro de banco de dados ao atualizar Plano de Ação.', [
                'id' => $planoAcao->id,
                'erro' => $e->getMessage(),
                'dados' => $request->all()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar o Plano de Ação. Verifique os dados e tente novamente.');
        }
    }

    public function destroy(PlanoAcao $planoAcao)
    {
        Log::info('Tentando excluir o Plano de Ação.', ['id' => $planoAcao->id]);

        try {
            $planoAcao->delete();

            Log::info('Plano de Ação excluído com sucesso.', ['id' => $planoAcao->id]);
            return redirect()->route('plano_acoes.index')->with('success', 'Plano de Ação excluído com sucesso.');
        
        } catch (QueryException $e) {
            Log::error('Erro de banco de dados ao excluir Plano de Ação (possível restrição de chave estrangeira).', [
                'id' => $planoAcao->id,
                'erro' => $e->getMessage()
            ]);

            return redirect()->route('plano_acoes.index')->with('error', 'Não foi possível excluir o Plano de Ação, pois ele pode estar vinculado a outros registros.');
        }
    }
}