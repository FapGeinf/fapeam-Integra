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
        $versionamentos = $this->versionamentoService->returnAllVersionamentos();
        return view('versionamentos.index', compact('versionamentos'));
    }

    public function storeVersionamento(VersionamentoRequest $request)
    {
        try {
            $this->versionamentoService->insertVersionamento($request->validated());
    
            return redirect()->back()->with('success', 'Versionamento inserido com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao registrar o versionamento: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Houve um erro inesperado ao inserir um versionamento no sistema');
        }
    }
    

    public function editVersionamento($id, VersionamentoRequest $request)
    {
        try {
            $this->versionamentoService->updateVersionamento($request->validated(), $id);

            return redirect()->back()->with('success', 'Versionamento foi atualizado com sucesso');
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
