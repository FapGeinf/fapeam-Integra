<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogsWithBackup extends Command
{
    protected $signature = 'logs:clear';

    protected $description = 'Faz backup e limpa os arquivos de logs action.log, error.log e laravel.log';

    public function handle()
    {
        $logsWithBackup = [
            storage_path('logs/error.log'),
            storage_path('logs/action.log'),
            storage_path('logs/laravel.log'),
        ];

        $backupFolder = storage_path('logs/backups/' . now()->format('d-m-Y'));
        if (!File::exists($backupFolder)) {
            File::makeDirectory($backupFolder, 0755, true);
        }

        foreach ($logsWithBackup as $log) {
            if (File::exists($log)) {
                File::copy($log, $backupFolder . '/' . basename($log));
                File::put($log, ''); 
            }
        }

        $this->info('Logs limpos com sucesso! Backup salvo em: ' . $backupFolder);
    }
}
