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
    public function indexRiscos()
    {
        try {
            $user = auth()->user();

            $prazo = Prazo::latest()->first();

            $tipoAcesso = $user->unidade->unidadeTipoFK;
            $unidadeDiretoria = $user->unidade->unidadeDiretoria;

            switch ($tipoAcesso) {
                case 1:
                case 3:
                    $riscos = Risco::with('monitoramentos.respostas')->get();
                    break;
                case 4:
                    if ($user->usuario_tipo_fk == 1) {
                        $riscos = Risco::with('monitoramentos.respostas')->get();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->with('monitoramentos.respostas')->get();
                    }
                    break;
                case 5:
                    if ($user->usuario_tipo_fk == 2) {
                        $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                            $query->where('unidadeDiretoria', $unidadeDiretoria);
                        })->with('monitoramentos.respostas')->get();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->with('monitoramentos.respostas')->get();
                    }
                    break;
                default:
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->with('monitoramentos.respostas')->get();
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
        } catch (ErrorException $e) {
            Log::error('Houve um erro inesperado ao retornar a lista de riscos', ['error' => $e->getMessage()]);
            throw new ErrorException('Houve um erro ao retornar a lista de riscos');
        }
    }

    public function indexAnalise()
    {
        try {

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
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao retornar a lista de riscos', ['error' => $e->getMessage()]);
            throw new Exception('Houve um erro ao recuperar a lista de riscos');
        }
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

    public function showRisco($id)
    {
        try {
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
        } catch (Exception $e) {
            Log::error('Houve um erro ao retornar o risco selecionado.', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Houve um erro ao retornar o risco selecionado');
        }
    }

    public function formStoreRisco()
    {
        return Unidade::all();
    }
    public function insertRisco(array $validatedData)
    {
        DB::beginTransaction();
        try {
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

            DB::commit();
            return $risco;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao inserir risco', ['error' => $e->getMessage()]);
            throw new Exception('Erro inesperado ao salvar o risco. Verifique os dados e tente novamente.');
        }
    }

    public function formEditRisco($id)
    {
        $unidades = Unidade::all();
        $risco = Risco::findOrFail($id);

        return [
            'unidades' => $unidades,
            'risco' => $risco
        ];
    }

    public function updateRisco($id, array $validatedData)
    {
        try {
            $risco = Risco::findOrFail($id);
            return $risco->update($validatedData);
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao atualizar o risco', ['error' => $e->getMessage()]);
            throw new Exception('Houve um erro ao atualizar o risco');
        }
    }

    public function deleteRisco($id)
    {
        try {
            $risco = Risco::findOrFail($id);
            return $risco->delete();
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao deletar o risco', ['error' => $e->getMessage(), 'risco_id' => $id]);
            throw new ErrorException('Houve um erro inesperado ao deletar o risco, tente novamente pfv.');
        }
    }

}