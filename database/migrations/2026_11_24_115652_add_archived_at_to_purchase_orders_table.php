<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fecha en que el comprador archivó la orden. Solo la saca de sus
     * pestañas: no cambia el estatus ni lo que ven los demás.
     */
    public function up(): void
    {
        // La columna puede existir ya en un entorno poblado desde un dump,
        // donde esta migración nunca llegó a registrarse.
        if (Schema::hasColumn('purchase_orders', 'archived_at')) {
            return;
        }

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->timestamp('archived_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
};
