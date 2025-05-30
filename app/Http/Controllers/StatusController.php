<?php

namespace App\Http\Controllers;

use App\Services\StatusService;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class StatusController extends Controller
{
    protected $statusService, $log;

    public function __construct(StatusService $statusService, LogService $log)
    {
        $this->middleware('auth');
        $this->statusService = $statusService;
        $this->log = $log;
    }

    public function implementadasShow()
    {
        $this->gerarLog('acessou a página de riscos implementados');
        return $this->handleStatus('IMPLEMENTADA', 'riscos.implementadas');
    }

    public function implementadasParcialmenteShow()
    {
        $this->gerarLog('acessou a página de riscos implementados parcialmente');
        return $this->handleStatus('IMPLEMENTADA PARCIALMENTE', 'riscos.implementadasParcialmente');
    }

    public function emImplementacaoShow()
    {
        $this->gerarLog('acessou a página de riscos em implementação');
        return $this->handleStatus('EM IMPLEMENTAÇÃO', 'riscos.emImplementacao');
    }

    public function naoImplementadaShow()
    {
        $this->gerarLog('acessou a página de riscos não implementados');
        return $this->handleStatus('NÃO IMPLEMENTADA', 'riscos.naoImplementada');
    }

    private function handleStatus($status, $view)
    {
        try {
            $dados = $this->statusService->getRiscosPorStatus($status);

            return view($view, $dados);
        } catch (Exception $e) {
            Log::error('Erro ao carregar riscos', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos.');
        }
    }

    private function gerarLog(string $descricaoAcao)
    {
        $usuario = Auth::user();
        $this->log->insertLog([
            'acao' => 'Visualização',
            'descricao' => "O usuário {$usuario->name} {$descricaoAcao}",
            'user_id' => $usuario->id,
        ]);
    }
}
