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
        Schema::create('management_project_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->constrained('management')->onDelete('cascade');
            $table->foreignId('project_purchase_id')->constrained('project_purchases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management_project_restrictions');
    }
    
};
