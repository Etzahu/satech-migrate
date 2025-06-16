<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('management', function (Blueprint $table) {
    //         //
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('management', function (Blueprint $table) {
    //         //
    //     });
    // }

     public function up(): void
    {
        Schema::table('management', function (Blueprint $table) {
            $this->down();
            // Verificar si la columna no existe
            if (!Schema::hasColumn('management', 'restriction_requisition')) {
                $table->enum('restriction_requisition', ['limitar', 'excluir'])->nullable()->after('acronym');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('management', function (Blueprint $table) {
            if (Schema::hasColumn('management', 'restriction_requisition')) {
                $table->dropColumn('restriction_requisition');
            }
        });
    }




};
