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
            $table->boolean('confidential')->default(false);
            $table->text('motive', 600);
            $table->text('observation', 600);
            $table->date('date_delivery');
            $table->string('delivery_address', 500);
            $table->string('status', 80)->nullable();
            $table->string('status_order', 80)->nullable();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('project_id')->constrained('project_purchases');
            $table->foreignId('approval_chain_id')->nullable()->constrained('purchase_requisition_approval_chains');
            $table->foreignId('assign_user_id')->nullable()->constrained('users');
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
