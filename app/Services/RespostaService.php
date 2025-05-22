<?php

namespace App\Services;
use App\Models\Resposta;
use App\Models\Monitoramento;
use App\Models\Risco;
use Exception;
use Log;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\User;
use Storage;
use Auth;
use App\Models\Unidade;

class RespostaService
{

    public function indexRespostas()
    {

        $user = Auth::user();
        $diretoriaId = $user->unidade->unidadeDiretoria;
        $unidades = Unidade::where('unidadeDiretoria', $diretoriaId)->get();
        $respostas = Resposta::whereHas('monitoramento.risco.unidade', function ($query) use ($diretoriaId) {
            $query->where('unidadeDiretoria', $diretoriaId);
        })
            ->with(['monitoramento.risco.unidade.diretoria', 'user'])
            ->get();

        return [
            'respostas' => $respostas,
            'unidades' => $unidades,
            'diretoriaId' => $diretoriaId
        ];
    }

    public function showRespostas($id)
    {
        $monitoramento = Monitoramento::with('respostas')->findOrFail($id);
        $homologacaoCompleta = $monitoramento->respostas->every(function ($resposta) {
            return $resposta->homologadaPresidencia && $resposta->homologadoDiretoria;
        });

        if ($homologacaoCompleta) {
            foreach ($monitoramento->respostas as $resposta) {
                $resposta->update(['homologacaoCompleta' => 1]);
            }
        }

        $respostas = Resposta::where('respostaMonitoramentoFK', $monitoramento->id)->get();

        return [
            'monitoramento' => $monitoramento,
            'respostas' => $respostas
        ];
    }

    public function insertRespostas($id, array $validatedData)
    {

        $monitoramento = Monitoramento::findOrFail($id);
        $filePath = null;

        if (isset($validatedData['anexo']) && $validatedData['anexo'] instanceof \Illuminate\Http\UploadedFile) {
            $filePath = $validatedData['anexo']->store('anexos', 'public');
            Log::info('Arquivo enviado com sucesso.', ['file_path' => $filePath]);
        } else {
            Log::info('Nenhum arquivo foi enviado.');
        }

        $resposta = Resposta::create([
            'respostaRisco' => $validatedData['respostaRisco'],
            'respostaMonitoramentoFk' => $monitoramento->id,
            'user_id' => auth()->id(),
            'anexo' => $filePath
        ]);

        $monitoramento->update([
            'statusMonitoramento' => $validatedData['statusMonitoramento']
        ]);

        Log::info('Status do monitoramento atualizado.', [
            'monitoramento_id' => $monitoramento->id,
            'new_status' => $monitoramento->statusMonitoramento
        ]);

        $allUsers = User::all();
        Log::info('Enviando notificações para usuários.', ['user_count' => $allUsers->count()]);

        foreach ($allUsers as $user) {
            $formattedDateTime = Carbon::parse($resposta->created_at)->format('d/m/Y \à\s H:i');
            $message = '<div><span>Nova mensagem!</span><br><br><div><span>Usuário: </span>' . htmlspecialchars($user->name) . '</div>' .
                '<div><span>Unidade: </span>' . ($user->unidade ? htmlspecialchars($user->unidade->unidadeNome) : 'Desconhecida') . '</div>' .
                '<div><span>Data do envio: </span>' . htmlspecialchars($formattedDateTime) . '</div><br>' .
                '</div>';

            $notification = Notification::create([
                'message' => $message,
                'global' => false,
                'monitoramentoId' => $monitoramento->id,
                'user_id' => $user->id
            ]);

            Log::info('Notificação criada.', ['notification_id' => $notification->id, 'user_id' => $user->id]);
        }

        return [
            'resposta' => $resposta,
            'monitoramento' => $monitoramento
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

            $resposta->anexo = $validatedData['anexo']->store('anexos', 'public');
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

}