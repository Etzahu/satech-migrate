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
            $table->string('currency', 5)->default('MXN');

            $table->string('type_payment', 100);
            $table->integer('discount')->default(0);
            $table->string('form_payment', 100);
            $table->string('term_payment', 100);
            $table->string('condition_payment', 100);
            $table->string('quote_folio', 100);
            $table->string('use_cfdi', 100);
            $table->text('shipping_method', 600);

            $table->integer('tax_iva')->default(0);
            $table->decimal('retention_iva', 10, 2)->default(0);
            $table->decimal('retention_isr', 10, 2)->default(0);
            $table->decimal('retention_another', 10, 2)->default(0);
            $table->date('initial_delivery_date');
            $table->date('final_delivery_date');
            $table->text('observations', 600);

            $table->string('status', 200);
            $table->foreignId('provider_id')->constrained('purchase_providers');
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
