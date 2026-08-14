<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UnidadeService;
use App\Services\UnidadeTipoService;
use App\Http\Requests\UnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class UnidadeController extends Controller
{
    protected $unidadeService, $unidadeTipoService;

    public function __construct(UnidadeService $unidadeService, UnidadeTipoService $unidadeTipoService)
    {
        $this->unidadeService = $unidadeService;
        $this->unidadeTipoService = $unidadeTipoService;
    }

    public function index()
    {
        try {
            $unidades = $this->unidadeService->getAllUnidades();
            $unidadesTipos = $this->unidadeTipoService->getAllUnidadeTipos();
            return view('unidades.index', compact('unidades', 'unidadesTipos'));
        } catch (Exception $e) {
            Log::error('Erro ao listar unidades: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de unidades.');
        }
    }

    public function show($id)
    {
        try {
            $unidade = $this->unidadeService->findUnidadeById($id);

            if (!$unidade) {
                Log::warning("Tentativa de visualizar unidade inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada.');
            }

            return view('unidades.show', compact('unidade'));
        } catch (Exception $e) {
            Log::error("Erro ao exibir unidade ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'unidade_id' => $id,
            ]);
            return redirect()->route('unidades.index')->with('error', 'Erro ao carregar os dados da unidade.');
        }
    }

    public function create()
    {
        try {
            $unidadeTipos = $this->unidadeTipoService->getAllUnidadeTipos();
            return view('unidades.create', compact('unidadeTipos'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar formulário de criação de unidade: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar o formulário.');
        }
    }

    public function store(UnidadeRequest $request)
    {
        try {
            $unidade = $this->unidadeService->createUnidade($request->validated());

            Log::info("Inserção de Unidade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'unidade_id' => $unidade->id ?? null,
            ]);

            return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao criar unidade: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar a unidade. Tente novamente.');
        }
    }

    public function edit($id)
    {
        try {
            $unidade = $this->unidadeService->findUnidadeById($id);

            if (!$unidade) {
                Log::warning("Tentativa de editar unidade inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada.');
            }

            $unidadeTipos = $this->unidadeTipoService->getAllUnidadeTipos();
            return view('unidades.edit', compact('unidade', 'unidadeTipos'));
        } catch (Exception $e) {
            Log::error("Erro ao carregar edição da unidade ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'unidade_id' => $id,
            ]);
            return redirect()->route('unidades.index')->with('error', 'Erro ao carregar o formulário de edição.');
        }
    }

    public function update(UpdateUnidadeRequest $request, $id)
    {
        try {
            $updated = $this->unidadeService->updateUnidade($id, $request->validated());

            if (!$updated) {
                Log::warning("Tentativa de atualizar unidade inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada.');
            }

            Log::info("Atualização de Unidade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'unidade_id' => $id,
            ]);

            return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao atualizar unidade ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'unidade_id' => $id,
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar a unidade. Tente novamente.');
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->unidadeService->deleteUnidade($id);

            if (!$deleted) {
                Log::warning("Tentativa de deletar unidade inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada.');
            }

            Log::info("Exclusão de Unidade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'unidade_id' => $id,
            ]);

            return redirect()->route('unidades.index')->with('success', 'Unidade deletada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao deletar unidade ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'unidade_id' => $id,
            ]);
            return redirect()->route('unidades.index')->with('error', 'Erro ao excluir a unidade. Tente novamente.');
        }
    }
}