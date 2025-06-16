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
        $this->down();
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table
                ->foreignId('pr_item_id_reference')
                ->nullable()
                ->after('purchase_order_id')
                ->constrained('purchase_requisition_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_order_items', 'pr_item_id_reference')) {
                $table->dropColumn('pr_item_id_reference');
            }
        });
    }
};
