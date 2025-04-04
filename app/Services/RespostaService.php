<?php
namespace App\Services;

use App\Models\Risco;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class RespostaService
{
    public function storeResposta($id, array $validatedData)
    {
        try {
            $monitoramento = Monitoramento::findOrFail($id);
            $risco = Risco::findOrFail($monitoramento->riscoFK);

            $filePath = null;
            if (isset($validatedData['anexo']) && $validatedData['anexo']->isValid()) {
                $filePath = $validatedData['anexo']->store('anexos', 'public');
                Log::info('File uploaded successfully', ['file_path' => $filePath]);
            } else {
                Log::info('No file uploaded');
            }

            $resposta = Resposta::create([
                'respostaRisco' => $validatedData['respostaRisco'],
                'respostaMonitoramentoFk' => $validatedData['respostaMonitoramentoFk'],
                'user_id' => auth()->id(),
                'anexo' => $filePath,
            ]);
            $monitoramento->update([
                'statusMonitoramento' => (int) 
                    $validatedData['statusMonitoramento']
            ]);

            Log::info('Monitoramento status updated', [
                'monitoramento_id' => $monitoramento->id,
                'new_status' => $monitoramento->statusMonitoramento
            ]);

            Log::info('Resposta created successfully', ['resposta_id' => $resposta->id]);

            $allUsers = User::all();
            Log::info('Attaching notifications to users', ['user_count' => $allUsers->count()]);

            foreach ($allUsers as $user) {
                $formattedDateTime = Carbon::parse($resposta->created_at)->format('d/m/Y \à\s H:i');
                $message = $this->generateNotificationMessage($user, $formattedDateTime);

                $notification = Notification::create([
                    'message' => $message,
                    'global' => false,
                    'monitoramentoId' => $monitoramento->id,
                    'user_id' => $user->id
                ]);

                Log::info('Notification created', ['notification_id' => $notification->id, 'user_id' => $user->id]);
            }

            return $resposta;

        } catch (Exception $e) {
            Log::error('Error storing resposta:', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);
            throw new Exception('Erro ao salvar a providência:');
        }
    }

    private function generateNotificationMessage($user, $formattedDateTime)
    {
        return '<div><span>Nova mensagem!</span><br><br><div><span>Usuário: </span>' . htmlspecialchars($user->name) . '</div>' .
            '<div><span>Unidade: </span>' . ($user->unidade ? htmlspecialchars($user->unidade->unidadeNome) : 'Desconhecida') . '</div>' .
            '<div><span>Data do envio: </span>' . htmlspecialchars($formattedDateTime) . '</div><br>' .
            '</div>';
    }

    public function updateResposta($id, array $validatedData)
    {
        try {
            $resposta = Resposta::findOrFail($id);

            $resposta->respostaRisco = $validatedData['respostaRisco'];

            if (isset($validatedData['anexo'])) {
                if ($resposta->anexo) {
                    Storage::disk('public')->delete($resposta->anexo);
                }
                $resposta->anexo = $validatedData['anexo']->store('anexos', 'public');
            }

            $resposta->save();

            return $resposta;

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Exception("Não foi encontrada uma providência com esta $id");
        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar a providência', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception('Houve um erro ao atualizar a providência.');
        }
    }


    public function deleteAnexo($id)
    {
        try {
            $resposta = Resposta::findOrFail($id);
    
            if (!$resposta->anexo) {
                Log::warning("Nenhum anexo encontrado para a Resposta ID: {$id}");
                throw new Exception("Não foi encontrado nenhum anexo para esta providência.");
            }
    
            Log::info("Anexo encontrado: {$resposta->anexo} para Resposta ID: {$id}");
    
            Storage::disk('public')->delete($resposta->anexo);
            $resposta->anexo = null;
            $resposta->save();
    
            Log::info("Anexo excluído e Resposta atualizada para ID: {$id}");
    
            return response()->json(['message' => 'Anexo removido com sucesso.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Erro: Resposta ID {$id} não encontrada.");
            throw new Exception("Resposta não encontrada para o ID: {$id}");
        } catch (Exception $e) {
            Log::error("Erro ao excluir anexo para Resposta ID: {$id}. Detalhes: " . $e->getMessage());
            throw new Exception("Erro ao excluir o anexo.");
        }
    }
    

    public function show($id)
    {
        $monitoramento = Monitoramento::with('respostas')->findorFail($id);
        $respostas = Resposta::where('respostaMonitoramentoFK', $monitoramento->id)->get();

        return [
            'monitoramento' => $monitoramento,
            'respostas' => $respostas
        ];
    }

    public function homologarResposta($id)
    {
        try {
            $resposta = Resposta::findOrFail($id);
            $user = Auth::user();

            $cpf = $user->cpf;
            $cpfMascarado = substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2);

            $dataHora = now()->format('d-m-Y H:i:s');
            $dataConcat = "Homologado em {$dataHora} {$user->name} id {$user->id} cpf {$cpfMascarado}";

            if ($user->usuario_tipo_fk == 2 && is_null($resposta->homologadoDiretoria)) {
                $resposta->update([
                    'homologadoDiretoria' => $dataConcat
                ]);
                return $dataConcat;
            } elseif (!is_null($resposta->homologadoDiretoria)) {
                throw new Exception('A providência já está homologada');
            } else {
                throw new Exception('Você não tem permissão para homologar');
            }
        } catch (Exception $e) {
            Log::error("Erro ao homologar providência: {$e->getMessage()}");
            throw new Exception('Houve um erro inesperado ao homologar a providência:');
        }
    }

}