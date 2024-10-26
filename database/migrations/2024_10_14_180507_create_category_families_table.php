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
        Schema::create('category_families', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 30);
            $table->string('type', 50);
            $table->foreignId('category_id')->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('category_families');
    }
};
