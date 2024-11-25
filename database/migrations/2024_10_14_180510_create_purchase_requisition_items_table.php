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
        Schema::create('purchase_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_requested');
            $table->integer('quantity_warehouse')->default(0);
            $table->integer('quantity_purchase');
            $table->text('observation', 600);
            $table->foreignId('user_warehouse_id')->nullable()->constrained('users');
            $table->foreignId('requisition_id')->constrained('purchase_requisitions')
                ->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_items');
    }
};
