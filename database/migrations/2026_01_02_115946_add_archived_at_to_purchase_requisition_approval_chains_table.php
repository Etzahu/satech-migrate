<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // La columna ya existe en los entornos que se poblaron desde un dump,
        // donde esta migración nunca llegó a registrarse.
        if (Schema::hasColumn('purchase_requisition_approval_chains', 'archived_at')) {
            return;
        }

        Schema::table('purchase_requisition_approval_chains', function (Blueprint $table) {
            $table->timestamp('archived_at')->nullable()->after('authorizer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requisition_approval_chains', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
};
