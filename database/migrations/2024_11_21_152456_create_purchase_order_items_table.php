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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_requested');
            $table->integer('quantity_purchase');
            $table->text('observation', 600);
            $table->foreignId('product_id')->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
