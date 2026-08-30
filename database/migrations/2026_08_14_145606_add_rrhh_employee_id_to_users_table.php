<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Vínculo explícito con el colaborador en rrhh.
 *
 * Normalmente `users.id` ya es el id de rrhh, pero parte de este padrón se dio
 * de alta aquí con su propia secuencia y hay filas cuyo id, en rrhh, es de
 * otra persona. Renumerarlas arrastraría sus requisiciones, así que en vez de
 * eso se guarda a quién corresponde cada fila: la sincronización sella este
 * campo una vez y a partir de ahí no vuelve a adivinar.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('rrhh_employee_id')->nullable()->after('id');

            // Único para que dos filas no puedan reclamar a la misma persona.
            $table->unique('rrhh_employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['rrhh_employee_id']);
            $table->dropColumn('rrhh_employee_id');
        });
    }
};
