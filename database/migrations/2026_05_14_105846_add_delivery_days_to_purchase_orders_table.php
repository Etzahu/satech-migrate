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
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->unsignedInteger('initial_delivery_days')->nullable()->after('retention_another');
            $table->unsignedInteger('final_delivery_days')->nullable()->after('initial_delivery_days');
            $table->date('initial_delivery_date')->nullable()->change();
            $table->date('final_delivery_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['initial_delivery_days', 'final_delivery_days']);
            $table->date('initial_delivery_date')->nullable(false)->change();
            $table->date('final_delivery_date')->nullable(false)->change();
        });
    }
};
