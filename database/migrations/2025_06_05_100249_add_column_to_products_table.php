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
        Schema::table('products', function (Blueprint $table) {
            $this->down();
            // Verificar si la columna no existe
            if (!Schema::hasColumn('products', 'type_purchase')) {
                $table->enum('type_purchase', ['servicio', 'proveeduria'])->default('proveeduria')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'type_purchase')) {
                $table->dropColumn('type_purchase');
            }
        });
    }
};
