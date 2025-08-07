<?php

namespace App\Services;
use App\Models\Resposta;
use App\Models\Monitoramento;
use Exception;
use InvalidArgumentException;
use Log;
use Storage;
use Auth;
use App\Models\Unidade;

class RespostaService
{

    public function indexRespostas()
    {
        $user = Auth::user();
        $isRoot = $user->usuario_tipo_fk == 4;
        $isAdmin = $user->usuario_tipo_fk == 1;

        if ($isRoot || $isAdmin) {
            $unidades = Unidade::all();
            $respostas = Resposta::with(['monitoramento.risco.unidade.diretoria', 'user'])
                ->whereNull('homologadaPresidencia')
                ->get();

            return [
                'respostas' => $respostas,
                'unidades' => $unidades,
                'diretoriaId' => null
            ];
        } else {
            $diretoriaId = $user->unidade->unidadeDiretoria;
            $unidades = Unidade::where('unidadeDiretoria', $diretoriaId)->get();
            $respostas = Resposta::whereHas('monitoramento.risco.unidade', function ($query) use ($diretoriaId) {
                $query->where('unidadeDiretoria', $diretoriaId);
            })
                ->with(['monitoramento.risco.unidade.diretoria', 'user'])
                ->whereNull('homologadoDiretoria')
                ->get();

            return [
                'respostas' => $respostas,
                'unidades' => $unidades,
                'diretoriaId' => $diretoriaId
            ];
        }
    }


    public function showRespostas($id)
    {
        $monitoramento = Monitoramento::with('respostas')->findOrFail($id);
        $homologacaoCompleta = $monitoramento->respostas->every(function ($resposta) {
            return $resposta->homologadaPresidencia && $resposta->homologadoDiretoria;
        });

        if ($homologacaoCompleta) {
            $idsParaAtualizar = $monitoramento->respostas
                ->where('homologacaoCompleta', '!=', 1)
                ->pluck('id');

            if ($idsParaAtualizar->isNotEmpty()) {
                Resposta::whereIn('id', $idsParaAtualizar)->update(['homologacaoCompleta' => 1]);
            }
        }


        $respostas = $monitoramento->respostas;

        return [
            'monitoramento' => $monitoramento,
            'respostas' => $respostas,
        ];
    }

    public function updateResposta($id, array $validatedData)
    {
        $resposta = Resposta::findOrFail($id);
        $monitoramento = Monitoramento::findOrFail($resposta->respostaMonitoramentoFk);

        $resposta->respostaRisco = $validatedData['respostaRisco'];

        if (isset($validatedData['anexo']) && $validatedData['anexo'] instanceof \Illuminate\Http\UploadedFile) {
            if ($resposta->anexo) {
                Storage::disk('public')->delete($resposta->anexo);
            }

            $file = $validatedData['anexo'];
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $resposta->anexo = $file->storeAs('anexos', $filename, 'public');
        }

        if (isset($validatedData['statusMonitoramento'])) {
            $monitoramento->update([
                'statusMonitoramento' => $validatedData['statusMonitoramento']
            ]);
        }

        $resposta->save();

        return $resposta;
    }

    public function destroyAnexo($id)
    {

        Log::info("Iniciando exclusão de anexo da resposta ID: $id");

        $resposta = Resposta::findOrFail($id);

        Log::info("Valor do campo 'anexo' da resposta ID $id: " . var_export($resposta->anexo, true));

        if (!empty($resposta->anexo)) {
            Log::info("Anexo encontrado: {$resposta->anexo}");

            if (Storage::disk('public')->exists($resposta->anexo)) {
                Storage::disk('public')->delete($resposta->anexo);
                Log::info("Arquivo {$resposta->anexo} deletado com sucesso.");
            } else {
                Log::warning("Arquivo {$resposta->anexo} não encontrado no disco.");
            }

            $resposta->anexo = null;
            $resposta->save();
            Log::info("Campo 'anexo' da resposta ID $id foi limpo e salvo.");

            return $resposta;
        } else {
            Log::info("Nenhum anexo para deletar na resposta ID: $id.");
        }
    }

    public function homologacaoResposta($id)
    {
        $resposta = Resposta::findOrFail($id);
        $user = Auth::user();
        $nome = $user->name;
        $cpf = $user->cpf;
        $cpfMascarado = substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2); // Mascarando o CPF

        $dataHora = now()->format('d-m-Y H:i:s');
        $dataConcat = "Homologado em {$dataHora} pelo usuário de {$nome}, id {$user->id} e cpf {$cpfMascarado}";

        $mensagem = '';

        if ($user->usuario_tipo_fk == 2) {
            if ($resposta->homologadoDiretoria === null) {
                $resposta->homologadoDiretoria = $dataConcat;
                $mensagem = 'Resposta homologada com sucesso pela diretoria!';
            } else {
                throw new Exception('A providência já está homologada pela diretoria.');
            }
        } elseif ($user->usuario_tipo_fk == 1) {
            if ($resposta->homologadaPresidencia === null) {
                $resposta->homologadaPresidencia = $dataConcat;
                $mensagem = 'Resposta homologada com sucesso pela presidência!';
            } else {
                throw new Exception('A providência já está homologada pela presidência.');
            }
            if ($resposta->homologadoDiretoria === null) {
                $resposta->homologadoDiretoria = $dataConcat;
            }
        } else {
            throw new Exception('Você não tem permissão para homologar.');
        }

        if (!empty($resposta->homologadoDiretoria) && !empty($resposta->homologadaPresidencia)) {
            $resposta->homologacaoCompleta = true;
        }

        $resposta->save();

        return [
            'resposta' => $resposta,
            'mensagem' => $mensagem,
            'dataConcat' => $dataConcat
        ];
    }

    public function homologacaoMultipla(array $data)
    {
        $user = Auth::user();

        $ids = $data['respostas_ids'];

        $homologadas = [];
        $naoHomologadas = [];

        $nome = $user->name;
        $cpf = $user->cpf;
        $cpfMascarado = substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2);
        $dataHora = now()->format('d-m-Y H:i:s');
        $dataConcat = "Homologado em {$dataHora} pelo usuário de {$nome}, id {$user->id} e cpf {$cpfMascarado}";

        foreach ($ids as $id) {
            $resposta = Resposta::find($id);

            if (!$resposta) {
                $naoHomologadas[] = ['id' => $id, 'motivo' => 'Resposta não encontrada'];
                continue;
            }

            if ($resposta->homologadaPresidencia !== null) {
                $naoHomologadas[] = ['id' => $id, 'motivo' => 'Já homologada pela presidência'];
                continue;
            }

            $resposta->homologadaPresidencia = $dataConcat;

            if ($resposta->homologadoDiretoria === null) {
                $resposta->homologadoDiretoria = $dataConcat;
            }

            if (!empty($resposta->homologadoDiretoria) && !empty($resposta->homologadaPresidencia)) {
                $resposta->homologacaoCompleta = true;
            }

            $resposta->save();
            $homologadas[] = $resposta->id;
        }

        return ['homologadas' => $homologadas, 'nao_homologadas' => $naoHomologadas];
    }



}