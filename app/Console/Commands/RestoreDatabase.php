<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file : Archivo dentro de storage/app/backups}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra la base de datos y la restaura desde un respaldo .sql';

    public function handle(): int
    {
        $filePath = storage_path('app/backups/'.$this->argument('file'));

        if (! file_exists($filePath)) {
            $this->error("El archivo $filePath no existe.");

            return self::FAILURE;
        }

        $connection = config('database.connections.mysql');
        $client = $connection['client_binary'] ?? 'mysql';

        // Se comprueba el cliente antes de borrar nada: si falla después del DROP, la base se pierde.
        $version = $this->mysql($connection, ['--version']);

        if (! $version->isSuccessful()) {
            $this->error("No se pudo ejecutar el cliente de MySQL ($client).");
            $this->line(trim($version->getErrorOutput()));
            $this->line('Pon la ruta completa en DB_MYSQL_CLIENT del .env, p. ej. C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysql.exe');

            return self::FAILURE;
        }

        $database = str_replace('`', '``', $connection['database']);

        $steps = [
            'Base de datos eliminada' => ['-e', "DROP DATABASE IF EXISTS `$database`"],
            'Base de datos creada' => ['-e', "CREATE DATABASE `$database` CHARACTER SET {$connection['charset']} COLLATE {$connection['collation']}"],
        ];

        foreach ($steps as $message => $arguments) {
            $process = $this->mysql($connection, $arguments);

            if (! $process->isSuccessful()) {
                $this->error(trim($process->getErrorOutput()));

                return self::FAILURE;
            }

            $this->info("$message: {$connection['database']}");
        }

        $this->info('Restaurando, puede tardar unos minutos...');

        $dump = fopen($filePath, 'rb');
        $restore = $this->mysql($connection, [$connection['database']], $dump, 3600);
        fclose($dump);

        if (! $restore->isSuccessful()) {
            $this->error(trim($restore->getErrorOutput()));

            return self::FAILURE;
        }

        $this->info('Base de datos restaurada exitosamente.');

        return self::SUCCESS;
    }

    /**
     * Ejecuta el cliente `mysql` sin pasar por la consola del sistema; la contraseña
     * va en MYSQL_PWD para que no aparezca en la línea de comandos ni en los errores.
     *
     * @param  array<string, mixed>  $connection
     * @param  array<int, string>  $arguments
     * @param  resource|null  $input
     */
    private function mysql(array $connection, array $arguments, mixed $input = null, ?float $timeout = 60): Process
    {
        $process = new Process(
            [
                $connection['client_binary'] ?? 'mysql',
                '--host='.$connection['host'],
                '--port='.$connection['port'],
                '--user='.$connection['username'],
                ...$arguments,
            ],
            env: ['MYSQL_PWD' => (string) $connection['password']],
            input: $input,
            timeout: $timeout,
        );

        $process->run();

        return $process;
    }
}
