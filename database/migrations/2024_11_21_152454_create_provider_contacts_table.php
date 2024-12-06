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
        Schema::create('provider_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job');
            $table->string('email');
            $table->string('cell_phone');
            $table->string('phone');
            $table->foreignId('provider_id')->constrained('purchase_providers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_contacts');
    }
};
