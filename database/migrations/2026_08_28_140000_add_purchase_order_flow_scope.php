<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Alcance del flujo de órdenes de compra por rol (Fase D1).
 *
 * El correo pide que en las órdenes apruebe Alan Anaya y autorice Sergio Ordaz
 * para los cinco departamentos operativos. Eso no puede resolverse con la
 * cadena de aprobación: la misma cadena sirve a la requisición, que debe seguir
 * pasando por el gerente de área. Así que los actores de la OC pasan a ser
 * roles y aquí queda marcado *dónde* aplican.
 *
 * Dos niveles de control, a propósito:
 *
 *  - `management.purchase_order_flow` — el alcance normal, por gerencia. Se
 *    marca una vez y cualquier cadena nueva de esa gerencia nace dentro del
 *    flujo: definirlo por "las cadenas donde Alan autoriza hoy" sería
 *    autorreferencial y las cadenas nuevas quedarían fuera sin que nadie lo note.
 *
 *  - `purchase_requisition_approval_chains.po_flow_excluded` — la excepción,
 *    por cadena. Existe porque dentro de esas gerencias hay cadenas que rutean
 *    a Gerencia de Contratos (Kevin Pérez) por gasto cargado a proyecto, y la
 *    cadena propia de Alan, donde él ya es solicitante y revisor. Si Operaciones
 *    decide que alguna debe quedarse como está, se marca desde la pantalla de
 *    cadenas sin necesidad de un despliegue.
 *
 * Nace **vacía**: ninguna cadena excluida. Es una decisión de Compras, no una
 * suposición de este código.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente.
 */
return new class extends Migration
{
    /** MTTOESP, ISW, ING, MAN, ST — los cinco departamentos del correo. */
    private const MANAGEMENT_IDS = [13, 8, 9, 5, 10];

    public function up(): void
    {
        if (! Schema::hasColumn('management', 'purchase_order_flow')) {
            Schema::table('management', function (Blueprint $table) {
                $table->boolean('purchase_order_flow')
                    ->default(false)
                    ->after('restriction_requisition');
            });
        }

        if (! Schema::hasColumn('purchase_requisition_approval_chains', 'po_flow_excluded')) {
            Schema::table('purchase_requisition_approval_chains', function (Blueprint $table) {
                $table->boolean('po_flow_excluded')
                    ->default(false)
                    ->after('authorizer_id');
            });
        }

        DB::table('management')
            ->whereIn('id', self::MANAGEMENT_IDS)
            ->update(['purchase_order_flow' => true, 'updated_at' => now()]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('management', 'purchase_order_flow')) {
            Schema::table('management', function (Blueprint $table) {
                $table->dropColumn('purchase_order_flow');
            });
        }

        if (Schema::hasColumn('purchase_requisition_approval_chains', 'po_flow_excluded')) {
            Schema::table('purchase_requisition_approval_chains', function (Blueprint $table) {
                $table->dropColumn('po_flow_excluded');
            });
        }
    }
};
