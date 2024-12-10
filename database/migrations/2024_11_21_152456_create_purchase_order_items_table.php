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
            $table->integer('quantity');
            $table->integer('unit_price')->default(0);
            $table->integer('sub_total')->default(0);
            $table->text('observation', 600)->nullable();
            $table->foreignId('product_id')->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('product_replace_id')->nullable()->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
