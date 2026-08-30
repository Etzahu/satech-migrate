<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * El nivel de autorización de la requisición pasa a ser opcional (Fase D2).
 *
 * "Alan solicita que se elimine el último nivel de autorización en los
 * departamentos de soldadura y ST" — Jorge Ojeda, 18-ago-2026, aceptado por
 * Denise al día siguiente: "solo se elimina el nivel de autorización de
 * soldadura y SSTT **en las requisiciones**".
 *
 * La tabla del correo escribe "N/A" en esa casilla, pero `authorizer_id` era
 * NOT NULL, así que Jorge tuvo que poner a Alan Anaya como sustituto temporal.
 * Esto habilita el "N/A" de verdad.
 *
 * Se usa SQL crudo y no `$table->foreignId(...)->nullable()->change()` porque
 * `change()` reescribe la columna y en MySQL arrastra la llave foránea; aquí
 * solo hace falta quitar el NOT NULL. El `->default(106)` de la migración de
 * 2024 nunca llegó a la base —se encadenó después de `->constrained()`, así que
 * aplicó al ForeignKeyDefinition—, de modo que no hay default que conservar.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE purchase_requisition_approval_chains MODIFY authorizer_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        // Volver a NOT NULL exige que ninguna cadena tenga el nivel vacío.
        $vacias = DB::table('purchase_requisition_approval_chains')
            ->whereNull('authorizer_id')
            ->count();

        if ($vacias > 0) {
            throw new RuntimeException(
                "No se puede revertir: {$vacias} cadenas tienen el nivel de autorización vacío. ".
                'Asígnales un autorizador antes de revertir esta migración.'
            );
        }

        DB::statement('ALTER TABLE purchase_requisition_approval_chains MODIFY authorizer_id BIGINT UNSIGNED NOT NULL');
    }
};
