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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 255);
            $table->date('date_delivery');
            $table->string('delivery_address', 500);
            $table->string('type', 50);
            $table->string('status', 50)->nullable();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('approval_chain_id')->constrained('purchase_requisition_approval_chains');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
