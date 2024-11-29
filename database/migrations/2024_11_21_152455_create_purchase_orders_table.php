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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->default('N/A');
            $table->string('currency',10)->default('MXN');
            // $table->foreignId('provider_id')->constrained('providers');
            $table->foreignId('purchaser_user_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('requisition_id')->constrained('purchase_requisitions')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
