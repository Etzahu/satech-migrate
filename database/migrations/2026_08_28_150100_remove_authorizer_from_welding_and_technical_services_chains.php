<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Quita el nivel de autorización de las requisiciones de Soldadura y Servicios
 * Técnicos (Fase D2, punto 5 del correo).
 *
 * Son las ocho cadenas donde Jorge puso a Alan Anaya como **sustituto
 * temporal**, porque `authorizer_id` era NOT NULL y no podía escribir el "N/A"
 * que pedía la tabla del correo. Ahora que la columna admite nulos, se deja
 * como se pidió.
 *
 *   Soldadura (ISW)          9, 67
 *   Servicios Técnicos (ST)  5, 10, 17, 27, 31, 102
 *
 * **Qué no toca.** Las cadenas 125, 126, 128 y 129 también son de Servicios
 * Técnicos, pero autorizan con Sergio Ordaz por ruteo a Gerencia de Contratos:
 * no son el caso del sustituto y vaciarlas sería una decisión de negocio que el
 * correo no pide. Si Operaciones lo decide, ahora se hace desde la pantalla de
 * cadenas sin necesidad de un despliegue.
 *
 * Verificado el 28-ago-2026: ninguna de las doce cadenas de esas gerencias
 * tiene requisiciones esperando autorización, así que el cambio no deja nada
 * atorado a medio flujo.
 *
 * El `down()` repone a Alan, que es el estado exacto de antes.
 */
return new class extends Migration
{
    /** Alan Alexis Anaya Arreola — el sustituto que hay que retirar. */
    private const SUBSTITUTE_USER_ID = 341;

    private const CHAIN_IDS = [9, 67, 5, 10, 17, 27, 31, 102];

    public function up(): void
    {
        DB::table('purchase_requisition_approval_chains')
            ->whereIn('id', self::CHAIN_IDS)
            ->where('authorizer_id', self::SUBSTITUTE_USER_ID)
            ->update(['authorizer_id' => null, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('purchase_requisition_approval_chains')
            ->whereIn('id', self::CHAIN_IDS)
            ->whereNull('authorizer_id')
            ->update(['authorizer_id' => self::SUBSTITUTE_USER_ID, 'updated_at' => now()]);
    }
};
