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
                'respostaMonitoramentoFK' => $monitoramento->id,
                'user_id' => auth()->id(),
                'anexo' => $filePath,
            ]);
            $monitoramento->update([
                'statusMonitoramento' => $validatedData['statusMonitoramento']
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

            throw $e;
        }
    }

    /**
     * Generate the notification message for users.
     *
     * @param  User   $user
     * @param  string $formattedDateTime
     * @return string
     */
    private function generateNotificationMessage($user, $formattedDateTime)
    {
        return '<div><span>Nova mensagem!</span><br><br><div><span>Usuário: </span>' . htmlspecialchars($user->name) . '</div>' .
            '<div><span>Unidade: </span>' . ($user->unidade ? htmlspecialchars($user->unidade->unidadeNome) : 'Desconhecida') . '</div>' .
            '<div><span>Data do envio: </span>' . htmlspecialchars($formattedDateTime) . '</div><br>' .
            '</div>';
    }

    public function updateResposta($id, array $validatedData)
    {
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
    }

    public function deleteAnexo($id)
    {

        $resposta = Resposta::findOrFail($id);

        if ($resposta->anexo) {
            Log::info('Anexo found: ' . $resposta->anexo . ' for Resposta ID: ' . $id);

            Storage::disk('public')->delete($resposta->anexo);

            $resposta->anexo = null;
           
            return $resposta->save();

            Log::info('Anexo deleted and Resposta updated for ID: ' . $id);
        } else {
            Log::info('No anexo found for Resposta ID: ' . $id);
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
            Log::error("Erro ao homologar resposta: {$e->getMessage()}");
            throw $e;
        }
    }

}