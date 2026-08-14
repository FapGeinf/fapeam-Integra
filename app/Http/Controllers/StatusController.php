<?php

namespace App\Http\Controllers;

use App\Services\StatusService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class StatusController extends Controller
{
    protected $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->middleware('auth');
        $this->statusService = $statusService;
    }

    public function implementadasShow()
    {
        return $this->handleStatus('IMPLEMENTADA', 'riscos.implementadas', 'acessou a página de riscos implementados');
    }

    public function implementadasParcialmenteShow()
    {
        return $this->handleStatus('IMPLEMENTADA PARCIALMENTE', 'riscos.implementadasParcialmente', 'acessou a página de riscos implementados parcialmente');
    }

    public function emImplementacaoShow()
    {
        return $this->handleStatus('EM IMPLEMENTAÇÃO', 'riscos.emImplementacao', 'acessou a página de riscos em implementação');
    }

    public function naoImplementadaShow()
    {
        return $this->handleStatus('NÃO IMPLEMENTADA', 'riscos.naoImplementada', 'acessou a página de riscos não implementados');
    }

    private function handleStatus($status, $view, $descricaoAcao)
    {
        try {
            Log::info("Acesso realizado", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'acao' => $descricaoAcao,
                'status' => $status
            ]);

            $dados = $this->statusService->getRiscosPorStatus($status);

            return view($view, $dados);
        } catch (Exception $e) {
            Log::error('Erro ao carregar riscos', [
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos.');
        }
    }
}