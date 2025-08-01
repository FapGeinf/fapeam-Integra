<?php

namespace App\Services;
use App\Models\Risco;
use App\Models\Prazo;
use App\Models\Notification;
use App\Models\Monitoramento;
use Log;
use ErrorException;
use Exception;
use App\Models\Unidade;
use DB;
use Carbon\Carbon;
class RiscoService
{
    public function findRiscoById($id)
    {
        return Risco::findOrFail($id);
    }

    public function indexRiscos()
    {
        $user = auth()->user();
        $prazo = Prazo::latest()->first();
        $tipoAcesso = $user->tipo?->id;
        $unidadeDiretoria = $user->unidade->unidadeDiretoria;
        switch ($tipoAcesso) {
            case 1:
                $riscos = Risco::all();
                break;
            case 4:
            case 5:
                $riscos = Risco::all();
                break;
            case 2:
                $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                    $query->where('unidadeDiretoria', $unidadeDiretoria);
                })->get();
                break;
            case 3:
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
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

        foreach ($riscos as $risco) {
            $respondidos = 0;

            foreach ($risco->monitoramentos as $monitoramento) {
                if ($monitoramento->respostas->isNotEmpty()) {
                    $respondidos++;
                }
            }

            $risco->monitoramentos_respondidos_count = $respondidos;
        }

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

    public function indexAnalise()
    {
        $user = auth()->user();
        $prazo = Prazo::latest()->first();
        $tipoAcesso = $user->tipo?->id;
        $unidadeDiretoria = $user->unidade->unidadeDiretoria;
        switch ($tipoAcesso) {
            case 1:
                $riscos = Risco::all();
                break;
            case 4:
            case 5:
                $riscos = Risco::all();
                break;
            case 2:
                $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                    $query->where('unidadeDiretoria', $unidadeDiretoria);
                })->get();
                break;
            case 3:
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
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

    private function filtraNotificacoes()
    {
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
    }

    public function showRisco($id)
    {

        $risco = Risco::with('monitoramentos.respostas')->find($id);
        foreach ($risco->monitoramentos as $monitoramento) {
            if ($monitoramento->respostas->isNotEmpty()) {
                $monitoramento->update([
                    'monitoramentoRespondido' => true
                ]);
            }
        }

        return [
            'risco' => $risco,
            'monitoramentos' => $risco->monitoramentos
        ];
    }

    public function formStoreRisco()
    {
        return Unidade::all();
    }
    public function insertRisco(array $validatedData)
    {

        $probabilidade = (int) ($validatedData['probabilidade'] ?? 0);
        $impacto = (int) ($validatedData['impacto'] ?? 0);
        $valor_nivel_de_risco = $probabilidade * $impacto;

        $nivel_de_risco = match (true) {
            $valor_nivel_de_risco >= 15 => 3,
            $valor_nivel_de_risco >= 5 => 2,
            $valor_nivel_de_risco > 0 => 1,
            default => 0,
        };

        $risco = Risco::create([
            'responsavelRisco' => $validatedData['responsavelRisco'],
            'riscoEvento' => $validatedData['riscoEvento'],
            'riscoCausa' => $validatedData['riscoCausa'],
            'riscoConsequencia' => $validatedData['riscoConsequencia'],
            'probabilidade' => $probabilidade,
            'impacto' => $impacto,
            'nivel_de_risco' => $nivel_de_risco,
            'riscoAno' => $validatedData['riscoAno'],
            'userIdRisco' => auth()->id(),
            'unidadeId' => $validatedData['unidadeId'],
        ]);

        if (!isset($validatedData['monitoramentos']) || !is_array($validatedData['monitoramentos'])) {
            throw new Exception('Dados de monitoramento inválidos.');
        }

        foreach ($validatedData['monitoramentos'] as $monitoramentoData) {
            $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);
            $inicio = Carbon::parse($monitoramentoData['inicioMonitoramento']);
            $fim = isset($monitoramentoData['fimMonitoramento']) ? Carbon::parse($monitoramentoData['fimMonitoramento']) : null;

            if (!$isContinuo && $fim && $fim->lte($inicio)) {
                throw new Exception('Fim do monitoramento não pode ser anterior ou igual ao início.');
            }

            Monitoramento::create([
                'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                'inicioMonitoramento' => $inicio,
                'fimMonitoramento' => $fim,
                'isContinuo' => $isContinuo,
                'riscoFK' => $risco->id,
            ]);
        }
        return $risco;
    }

    public function formEditRisco($id)
    {
        $unidades = Unidade::all();
        $risco = $this->findRiscoById($id);

        return [
            'unidades' => $unidades,
            'risco' => $risco
        ];
    }

    public function updateRisco($id, array $validatedData)
    {
        $risco = $this->findRiscoById($id);
        $risco->update($validatedData);
        return $risco;
    }

    public function deleteRisco($id)
    {
        $risco = $this->findRiscoById($id);

        if (!$risco) {
            throw new Exception("Risco com ID $id não encontrado.");
        }

        $deleted = $risco->delete();

        if (!$deleted) {
            throw new Exception("Falha ao deletar o risco com ID $id.");
        }

        return true;
    }

}