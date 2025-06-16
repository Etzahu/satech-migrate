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
        Schema::table('purchase_requisitions', function (Blueprint $table) {
            // Verificar si la columna no existe
            $this->down();
            if (!Schema::hasColumn('purchase_requisitions', 'category')) {
                $table->enum('category', ['servicio', 'proveeduria'])->nullable()->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requisitions', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requisitions', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
