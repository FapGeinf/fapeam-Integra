<?php

namespace App\Listeners;

use App\Events\PrazoProximo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CriarNotificacaoPrazo
{
    public function handle(PrazoProximo $event)
    {
        Log::info('Listener CriarNotificacaoPrazo disparado.');

        $hoje = Carbon::now()->startOfDay();
        $prazoData = Carbon::parse($event->prazo->data)->startOfDay();
        $diasParaPrazo = $prazoData->diffInDays($hoje, false);

        Log::info('Dias para o prazo: ' . $diasParaPrazo);

        if ($diasParaPrazo <= 7) {
            $diasParaPrazoAbs = abs($diasParaPrazo);
            $notificacaoPrazo = "O prazo para o relatório está se aproximando em {$diasParaPrazoAbs} dias para chegar ao fim.";

            Log::info('Verificando existência de notificação para: ' . $notificacaoPrazo);

            Notification::create([
                'message' => $notificacaoPrazo,
                'global' => true,
            ]);
        } else {
            Log::info('Dias para o prazo não estão no intervalo esperado.');
        }
    }
}
