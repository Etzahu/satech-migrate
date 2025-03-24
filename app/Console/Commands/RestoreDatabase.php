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
    protected $signature = 'db:restore {filename}';
    protected $description = 'Restore the database from a backup';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener el nombre del archivo de respaldo
        $filename = $this->argument('filename');
        $path = storage_path('app/backups/' . $filename);

        // Verificar si el archivo de respaldo existe
        if (!file_exists($path)) {
            $this->error('El archivo de respaldo no existe: ' . $filename);
            return;
        }

        // Obtener las credenciales de la base de datos
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        // Paso 1: Eliminar la base de datos existente
        $dropCommand = sprintf(
            'mysql -u%s -p%s -e "DROP DATABASE IF EXISTS %s;"',
            $dbUser,
            $dbPass,
            $dbName
        );

        $dropProcess = Process::fromShellCommandline($dropCommand);
        $dropProcess->run();

        if (!$dropProcess->isSuccessful()) {
            throw new ProcessFailedException($dropProcess);
        }

        $this->info('Base de datos eliminada: ' . $dbName);

        // Paso 2: Crear una nueva base de datos vacía
        $createCommand = sprintf(
            'mysql -u%s -p%s -e "CREATE DATABASE %s;"',
            $dbUser,
            $dbPass,
            $dbName
        );

        $createProcess = Process::fromShellCommandline($createCommand);
        $createProcess->run();

        if (!$createProcess->isSuccessful()) {
            throw new ProcessFailedException($createProcess);
        }

        $this->info('Base de datos creada: ' . $dbName);

        // Paso 3: Cargar el respaldo en la nueva base de datos
        $restoreCommand = sprintf(
            'mysql -u%s -p%s %s < %s',
            $dbUser,
            $dbPass,
            $dbName,
            $path
        );

        $restoreProcess = Process::fromShellCommandline($restoreCommand);
        $restoreProcess->run();

        if (!$restoreProcess->isSuccessful()) {
            throw new ProcessFailedException($restoreProcess);
        }

        $this->info('Base de datos restaurada desde: ' . $filename);
    }
}
