<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file}';
    protected $description = 'Restore the database from a backup';

    public function handle()
    {
        // $filename = $this->argument('filename');
        $file= $this->argument('file');
        $filePath = storage_path('app/backups/' . $file);

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            $this->error("El archivo $filePath no existe.");
            return 1;
        }

             // Paso 1: Eliminar la base de datos existente
        $dropCommand = sprintf(
            'mysql -u%s -p%s -e "DROP DATABASE IF EXISTS %s;"',
            $username,
            $password,
            $database
        );

        $dropProcess = Process::fromShellCommandline($dropCommand);
        $dropProcess->run();

        if (!$dropProcess->isSuccessful()) {
            throw new ProcessFailedException($dropProcess);
        }

        $this->info('Base de datos eliminada: ' . $database);


         // Paso 2: Crear una nueva base de datos vacía
        $createCommand = sprintf(
            'mysql -u%s -p%s -e "CREATE DATABASE %s;"',
            $username,
            $password,
            $database
        );

        $createProcess = Process::fromShellCommandline($createCommand);
        $createProcess->run();

        if (!$createProcess->isSuccessful()) {
            throw new ProcessFailedException($createProcess);
        }

        $this->info('Base de datos creada: ' . $database);

        
        // Comando para restaurar
        $command = sprintf(
            'mysql -h %s -u %s %s %s < %s',
            $host,
            $username,
            $password ? '-p' . escapeshellarg($password) : '',
            $database,
            escapeshellarg($filePath)
        );

        // Ejecuta el comando
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600); // Timeout de 1 hora para archivos grandes
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info('Base de datos restaurada exitosamente.');
        return 0;
    }

}
