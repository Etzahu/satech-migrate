<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * `db:restore` borra la base antes de restaurar, así que debe fallar sin tocar nada
 * cuando falta el respaldo o el cliente `mysql`.
 *
 * La restauración completa se prueba contra una base desechable, nunca la del .env.
 */
class RestoreDatabaseCommandTest extends TestCase
{
    private const SCRATCH_DATABASE = 'zz_restore_command_test';

    private const FIXTURE = 'zz-restore-command-test.sql';

    protected function tearDown(): void
    {
        @unlink(storage_path('app/backups/'.self::FIXTURE));
        DB::statement('DROP DATABASE IF EXISTS `'.self::SCRATCH_DATABASE.'`');

        parent::tearDown();
    }

    public function test_it_fails_when_the_backup_file_does_not_exist(): void
    {
        $this->artisan('db:restore', ['file' => 'no-existe.sql'])
            ->expectsOutputToContain('no existe')
            ->assertFailed();
    }

    public function test_it_does_not_touch_the_database_when_the_mysql_client_cannot_run(): void
    {
        $this->writeFixture('CREATE TABLE restored (id INT);');
        config(['database.connections.mysql.client_binary' => 'C:/no/existe/mysql.exe']);

        $this->artisan('db:restore', ['file' => self::FIXTURE])
            ->expectsOutputToContain('No se pudo ejecutar el cliente de MySQL')
            ->expectsOutputToContain('DB_MYSQL_CLIENT')
            ->doesntExpectOutputToContain('Base de datos eliminada')
            ->assertFailed();

        $this->assertTrue(DB::getSchemaBuilder()->hasTable('users'));
    }

    public function test_it_recreates_the_database_from_the_backup(): void
    {
        $client = config('database.connections.mysql.client_binary');
        $probe = new Process([$client, '--version']);
        $probe->run();

        if (! $probe->isSuccessful()) {
            $this->markTestSkipped("El cliente $client no está disponible; configura DB_MYSQL_CLIENT.");
        }

        DB::statement('CREATE DATABASE `'.self::SCRATCH_DATABASE.'`');
        DB::statement('CREATE TABLE `'.self::SCRATCH_DATABASE.'`.`leftover` (id INT)');
        $this->writeFixture("CREATE TABLE restored (name VARCHAR(20));\nINSERT INTO restored VALUES ('ñandú');");
        config(['database.connections.mysql.database' => self::SCRATCH_DATABASE]);

        $this->artisan('db:restore', ['file' => self::FIXTURE])
            ->expectsOutputToContain('Base de datos restaurada exitosamente.')
            ->assertSuccessful();

        $tables = collect(DB::select('SELECT table_name AS name FROM information_schema.tables WHERE table_schema = ?', [self::SCRATCH_DATABASE]))
            ->pluck('name')
            ->all();

        $this->assertSame(['restored'], $tables);
        $this->assertSame('ñandú', DB::selectOne('SELECT name FROM `'.self::SCRATCH_DATABASE.'`.restored')->name);
    }

    private function writeFixture(string $sql): void
    {
        file_put_contents(storage_path('app/backups/'.self::FIXTURE), "SET NAMES utf8mb4;\n".$sql);
    }
}
