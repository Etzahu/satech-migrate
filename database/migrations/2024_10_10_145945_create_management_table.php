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
        Schema::create('management', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('acronym', 10)->unique();
            $table->foreignId('responsible_id')->constrained('users');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
             $table->foreignId('management_id')->nullable()->constrained('management');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management');
    }
};
