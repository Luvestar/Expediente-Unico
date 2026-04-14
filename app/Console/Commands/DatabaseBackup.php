<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup de la base de datos';

    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        
        $backupFile = storage_path('backups/backup_' . date('Y-m-d_H-i-s') . '.sql');
        
        if (!is_dir(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }
        
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$backupFile}";
        
        exec($command);
        
        // Eliminar backups antiguos (más de 30 días)
        $files = glob(storage_path('backups/backup_*.sql'));
        foreach ($files as $file) {
            if (filemtime($file) < strtotime('-30 days')) {
                unlink($file);
            }
        }
        
        $this->info('Backup completado: ' . $backupFile);
    }
}