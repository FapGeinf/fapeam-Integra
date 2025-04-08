<?php

namespace App\Services;

use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Prazo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

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
        try {
            $probabilidade = isset($validatedData['probabilidade']) ? (int) $validatedData['probabilidade'] : 0;
            $impacto = isset($validatedData['impacto']) ? (int) $validatedData['impacto'] : 0;
    
            $valor_nivel_de_risco = $probabilidade * $impacto;
    
            if ($valor_nivel_de_risco >= 15) {
                $nivel_de_risco = 3; 
            } elseif ($valor_nivel_de_risco >= 5) {
                $nivel_de_risco = 2; 
            } elseif ($valor_nivel_de_risco > 0) {
                $nivel_de_risco = 1; 
            } else {
                $nivel_de_risco = 0; 
            }
    
            $risco = Risco::create([
                'responsavelRisco' => $validatedData['responsavelRisco'],
                'riscoEvento' => $validatedData['riscoEvento'],
                'riscoCausa' => $validatedData['riscoCausa'],
                'riscoConsequencia' => $validatedData['riscoConsequencia'],
                'probabilidade' => $probabilidade,
                'impacto' => $impacto,
                'nivel_de_risco' => $nivel_de_risco,
                'unidadeId' => $validatedData['unidadeId'],
                'riscoAno' => $validatedData['riscoAno'],
                'userIdRisco' => auth()->id()
            ]);
    
            $monitoramentos = [];
    
            foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);
    
                if (
                    !$isContinuo &&
                    isset($monitoramentoData['fimMonitoramento']) &&
                    $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']
                ) {
                    throw new Exception("Erro no monitoramento #{$index}: Fim do monitoramento não pode ser anterior ao início.");
                }
    
                $monitoramentos[] = Monitoramento::create([
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
                'monitoramentos' => $monitoramentos
            ];
        } catch (Exception $e) {
            Log::error('Erro ao criar o risco', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id(),
            ]);
            throw new Exception("Erro ao criar risco.");
        }
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
        try {
            $risco = Risco::findOrFail($id);
            $risco->update($data);
            return $risco;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Exception("Risco não encontrado para o ID: {$id}");
        } catch (Exception $e) {
            Log::error('Erro ao atualizar o risco',[
                'error' => $e->getMessage(),
                'data' => $data,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Erro ao atualizar risco. " );
        }
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