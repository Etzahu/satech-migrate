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
        Schema::create('purchase_order_sheet_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('columns')->nullable(); // Columnas seleccionadas
            $table->integer('days_range')->default(30); // Rango de días
            $table->date('custom_start_date')->nullable(); // Fecha inicio personalizada
            $table->date('custom_end_date')->nullable(); // Fecha fin personalizada
            $table->string('date_range_type')->default('days'); // 'days' o 'custom'
            $table->json('buyers')->nullable(); // IDs de compradores
            $table->json('type_purchase')->nullable(); // Tipos de compra
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_sheet_configs');
    }
};
