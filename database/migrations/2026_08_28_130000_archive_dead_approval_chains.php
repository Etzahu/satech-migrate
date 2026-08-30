<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Archiva tres cadenas de aprobación que ya no pueden usarse.
 *
 * Salieron al auditar el alcance de la Fase D (28-ago-2026): son de las cinco
 * gerencias del correo pero no tienen a Alan Anaya de autorizador, y al
 * revisarlas resultaron inservibles —tienen participantes dados de baja, así
 * que `scopeSelectable()` ya las excluye de cualquier requisición nueva—.
 *
 * Archivar en vez de borrar: `archived_at` las retira de circulación y conserva
 * el historial de las requisiciones y órdenes que las usaron. Reversible.
 *
 *   88 · ING  — solicita, revisa y aprueba dados de baja (Adriana González,
 *               Omar Alvarado, Guillermo Gutiérrez). 14 requisiciones y 17
 *               órdenes históricas; las 3 órdenes en borrador que le quedan
 *               llevan más de 9 meses sin movimiento.
 *   95 · MAN  — los cuatro participantes dados de baja. Cero documentos.
 *  133 · MTTOESP — solicitante dado de baja (Manuel Jiménez). Cero documentos.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente: solo toca las que siguen sin archivar.
 */
return new class extends Migration
{
    private const CHAIN_IDS = [88, 95, 133];

    public function up(): void
    {
        DB::table('purchase_requisition_approval_chains')
            ->whereIn('id', self::CHAIN_IDS)
            ->whereNull('archived_at')
            ->update([
                'archived_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('purchase_requisition_approval_chains')
            ->whereIn('id', self::CHAIN_IDS)
            ->update([
                'archived_at' => null,
                'updated_at' => now(),
            ]);
    }
};
