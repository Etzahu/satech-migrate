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
        Schema::create('project_purchase_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_purchase_id')->constrained('project_purchases')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('project_usage_id')->constrained('project_usages')->onUpdate('cascade')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_purchase_usage');
    }
};
