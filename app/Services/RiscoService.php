<?php

namespace App\Services;

use App\Events\NovaRespostaCriada;
use App\Events\PrazoProximo;
use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Mail\ResponseNotification;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\Prazo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Diretoria;

class RiscoService
{
    public function indexRiscos()
    {
        $user = auth()->user();
        $prazo = Prazo::latest()->first();
        $user = auth()->user();
        $tipoAcesso = $user->unidade->unidadeTipoFK;
        $unidadeDiretoria = $user->unidade->unidadeDiretoria;

        switch ($tipoAcesso) {
            case 1:
            case 3:
                $riscos = Risco::all();
                break;
            case 4:
                if ($user->usuario_tipo_fk == 1) {
                    $riscos = Risco::all();
                } else {
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                }
                break;
            case 5:
                if ($user->usuario_tipo_fk == 2) {
                    $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                        $query->where('unidadeDiretoria', $unidadeDiretoria);
                    })->get();
                } else {
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                }
                break;
            default:
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                break;
        }

        $riscosAbertos = $riscos->count();

        $riscosAbertosHoje = Risco::whereDate('created_at', Carbon::today())->count();

        $notificacoes = $this->filtraNotificacoes();

        $notificacoesNaoLidas = $notificacoes->whereNull('read_at');
        $notificacoesLidas = $notificacoes->whereNotNull('read_at');
        $unidades = Unidade::all();

        return [
            'riscos' => $riscos,
            'prazo' => $prazo ? $prazo->data : null,
            'riscosAbertos' => $riscosAbertos,
            'riscosAbertosHoje' => $riscosAbertosHoje,
            'notificacoes' => $notificacoes,
            'notificacoesNaoLidas' => $notificacoesNaoLidas,
            'notificacoesLidas' => $notificacoesLidas,
            'unidades' => $unidades
        ];
    }

    public function analiseRiscos()
    {
        $user = auth()->user();
        $prazo = Prazo::latest()->first();
        $user = auth()->user();
        $tipoAcesso = $user->unidade->unidadeTipoFK;
        $unidadeDiretoria = $user->unidade->unidadeDiretoria;

        switch ($tipoAcesso) {
            case 1:
            case 3:
                $riscos = Risco::all();
                break;
            case 4:
                if ($user->usuario_tipo_fk == 1) {
                    $riscos = Risco::all();
                } else {
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                }
                break;
            case 5:
                if ($user->usuario_tipo_fk == 2) {
                    $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                        $query->where('unidadeDiretoria', $unidadeDiretoria);
                    })->get();
                } else {
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                }
                break;
            default:
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                break;
        }

        $riscosAbertos = $riscos->count();
        $riscosAbertosHoje = Risco::whereDate('created_at', Carbon::today())->count();
        $notificacoes = $this->filtraNotificacoes();
        $notificacoesNaoLidas = $notificacoes->whereNull('read_at');
        $notificacoesLidas = $notificacoes->whereNotNull('read_at');

        $unidades = Unidade::all();

        return [
            'riscos' => $riscos,
            'prazo' => $prazo ? $prazo->data : null,
            'riscosAbertos' => $riscosAbertos,
            'riscosAbertosHoje' => $riscosAbertosHoje,
            'notificacoes' => $notificacoes,
            'notificacoesNaoLidas' => $notificacoesNaoLidas,
            'notificacoesLidas' => $notificacoesLidas,
            'unidades' => $unidades
        ];
    }

    public function show($id)
    {
        $risco = Risco::with(['monitoramentos'])->findOrFail($id);
        $monitoramentos = $risco->monitoramentos;
        return [
            'risco' => $risco,
            'monitoramentos' => $monitoramentos
        ];
    }

    public function formCreateRisco()
    {
        $unidades = Unidade::all();
        return $unidades;
    }

    public function storeRisco(array $validatedData)
    {
        $risco = Risco::create([
            'responsavelRisco' => $validatedData['responsavelRisco'],
            'riscoEvento' => $validatedData['riscoEvento'],
            'riscoCausa' => $validatedData['riscoCausa'],
            'riscoConsequencia' => $validatedData['riscoConsequencia'],
            'nivel_de_risco' => (int) $validatedData['nivel_de_risco'],
            'unidadeId' => $validatedData['unidadeId'],
            'riscoAno' => $validatedData['riscoAno'],
            'userIdRisco' => auth()->id()
        ]);

        foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
            $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

            if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                throw new Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
            }

            
            $monitoramento = Monitoramento::create([
                'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                'isContinuo' => $isContinuo,
                'riscoFK' => $risco->id,
            ]);
        }

        return [
            'risco' => $risco,
            'monitoramentos' => $risco->monitoramentos
        ];

    }

    public function editFormRisco($id)
    {
        $unidades = Unidade::all();
        $risco = Risco::findOrFail($id);

        return [
            'unidades' => $unidades,
            'risco' => $risco
        ];
    }

    public function updateRisco(array $data, $id)
    {
        $risco = Risco::findOrFail($id);
        $risco->update($data);
        return $risco; 
    }


    public function deleteRisco($id)
    {
        $risco = Risco::findorFail($id);
        return $risco->delete();
    }

    private function filtraNotificacoes()
    {
        try {
            $user = auth()->user();

            if (!$user->unidade || !$user->unidade->unidadeTipo) {
                Log::info('Usuário não possui uma unidade ou tipo de unidade associada', ['user_id' => $user->id]);
                return collect();
            }

            $unidadeTipo = $user->unidade->unidadeTipo->id;

            switch ($unidadeTipo) {
                case 1:
                    $notificacoes = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->get();
                    break;

                case 2:
                    $notificacoes = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->whereHas('monitoramento.risco.unidade', function ($query) use ($user) {
                            $query->where('unidadeId', $user->unidade->id);
                        })
                        ->get();
                    break;

                default:
                    Log::info('Tipo de unidade não reconhecido', ['user_id' => $user->id, 'unidade_tipo' => $unidadeTipo]);
                    return collect();
            }

            return $notificacoes;
        } catch (Exception $e) {
            Log::error('Erro ao filtrar notificações', ['error' => $e->getMessage()]);
            return collect();
        }
    }
}