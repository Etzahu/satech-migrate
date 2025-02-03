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
        Schema::create('project_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('name', 255)->unique();
            $table->string('status');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('requester_id')->nullable()->constrained('users');
            $table->foreignId('registered_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_purchases');
    }
};
