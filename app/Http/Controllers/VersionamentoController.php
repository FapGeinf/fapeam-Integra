<?php

namespace App\Http\Controllers;

use App\Http\Requests\VersionamentoRequest;
use Exception;
use Illuminate\Http\Request;
use App\Services\VersionamentoService;
use Log;

class VersionamentoController extends Controller
{
    protected $versionamentoService;

    public function __construct(VersionamentoService $versionamentoService)
    {
        $this->versionamentoService = $versionamentoService;
    }

    public function index()
    {
        try {
            $versionamentos = $this->versionamentoService->returnAllVersionamentos();
            return view('versionamentos.index', compact('versionamentos'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar versionamentos (index)', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar os versionamentos.');
        }
    }

    public function publicVersionamentos()
    {
        try {
            $versionamentos = $this->versionamentoService->versionamentosOrderByDate();
            return view('versionamentos.showVersionamento', compact('versionamentos'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar versionamentos públicos', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar os versionamentos públicos.');
        }
    }

    public function createVersionamento()
    {
        try {
            return view('versionamentos.create');
        } catch (Exception $e) {
            Log::error('Erro ao acessar a página de criação de versionamento', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao acessar a página de criação de versionamento.');
        }
    }
    public function storeVersionamento(VersionamentoRequest $request)
    {
        try {
            $this->versionamentoService->insertVersionamento($request->validated());

            return redirect()->route('versionamentos.index')->with('success', 'Foi inserido um versionamento com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao registrar o versionamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um erro inesperado ao inserir um versionamento no sistema');
        }
    }

    public function editFormVersionamento($id)
    {
        try {
            $versionamento = $this->versionamentoService->getVersionamentoById($id);
            return view('versionamentos.edit', compact('versionamento'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar o formulário de edição do versionamento', ['error' => $e->getMessage(), 'versionamento_id' => $id]);
            return redirect()->back()->with('error', 'Erro ao carregar o formulário de edição do versionamento.');
        }
    }

    public function updateVersionamento($id, VersionamentoRequest $request)
    {
        try {
            $this->versionamentoService->updateVersionamento($request->validated(), $id);

            return redirect()->route('versionamentos.index')->with('success', 'O versionamento selecionado foi atualizado com sucesso');
        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar o versionamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um erro inesperado ao atualizar um versionamento');
        }
    }

    public function destroyVersionamento($id)
    {
        try {
            $this->versionamentoService->deleteVersionamento($id);

            return redirect()->back()->with('success', 'Versionamento excluído com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao excluir o versionamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um erro inesperado ao excluir o versionamento');
        }
    }
}
