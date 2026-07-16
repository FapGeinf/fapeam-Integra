<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiretoriaService;
use App\Http\Requests\DiretoriaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class DiretoriaController extends Controller
{
    protected $diretoriaService;

    public function __construct(DiretoriaService $diretoriaService)
    {
        $this->diretoriaService = $diretoriaService;
    }

    public function index()
    {
        try {
            $diretorias = $this->diretoriaService->returnDiretoriaOrderedByName();
            return view('diretorias.index', compact('diretorias'));
        } catch (Exception $e) {
            Log::error('Erro ao listar diretorias: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de diretorias.');
        }
    }

    public function show($id)
    {
        try {
            $diretoria = $this->diretoriaService->findDiretoriaById($id);

            if (!$diretoria) {
                Log::warning("Tentativa de visualizar diretoria inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }

            return view('diretorias.show', compact('diretoria'));
        } catch (Exception $e) {
            Log::error("Erro ao exibir diretoria ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'diretoria_id' => $id,
            ]);
            return redirect()->route('diretorias.index')->with('error', 'Erro ao carregar os dados da diretoria.');
        }
    }

    public function create()
    {
        return view('diretorias.create');
    }

    public function store(DiretoriaRequest $request)
    {
        try {
            $diretoria = $this->diretoriaService->createDiretoria($request->validated());

            Log::info("Inserção de Diretoria realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'diretoria_id' => $diretoria->id ?? null,
            ]);

            return redirect()->route('diretorias.index')->with('success', 'Diretoria criada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao criar diretoria: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar a diretoria. Tente novamente.');
        }
    }

    public function edit($id)
    {
        try {
            $diretoria = $this->diretoriaService->findDiretoriaById($id);

            if (!$diretoria) {
                Log::warning("Tentativa de editar diretoria inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }

            return view('diretorias.edit', compact('diretoria'));
        } catch (Exception $e) {
            Log::error("Erro ao carregar edição da diretoria ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'diretoria_id' => $id,
            ]);
            return redirect()->route('diretorias.index')->with('error', 'Erro ao carregar o formulário de edição.');
        }
    }

    public function update(DiretoriaRequest $request, $id)
    {
        try {
            $updatedDiretoria = $this->diretoriaService->updateDiretoria($id, $request->validated());

            if (!$updatedDiretoria) {
                Log::warning("Tentativa de atualizar diretoria inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }

            Log::info("Atualização de Diretoria realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'diretoria_id' => $id,
            ]);

            return redirect()->route('diretorias.index')->with('success', 'Diretoria atualizada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao atualizar diretoria ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'diretoria_id' => $id,
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar a diretoria. Tente novamente.');
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->diretoriaService->deleteDiretoria($id);

            if (!$deleted) {
                Log::warning("Tentativa de deletar diretoria inexistente (ID: $id)", [
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }

            Log::info("Exclusão de Diretoria realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'diretoria_id' => $id,
            ]);

            return redirect()->route('diretorias.index')->with('success', 'Diretoria deletada com sucesso!');
        } catch (Exception $e) {
            Log::error("Erro ao deletar diretoria ID $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'diretoria_id' => $id,
            ]);
            return redirect()->route('diretorias.index')->with('error', 'Erro ao excluir a diretoria. Tente novamente.');
        }
    }
}