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
            $table->dropColumn('initial_delivery_days');
            $table->renameColumn('final_delivery_days', 'delivery_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->renameColumn('delivery_days', 'final_delivery_days');
            $table->unsignedInteger('initial_delivery_days')->nullable()->after('retention_another');
        });
    }
};
