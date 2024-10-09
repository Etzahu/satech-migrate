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
        Schema::create('sub_drawing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code',10)->unique();
            $table->foreignId('drawing_category_id')->constrained('drawing_categories')->cascade();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_drawing_categories');
    }
};
