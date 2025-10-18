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
        Schema::create('purchase_providers', function (Blueprint $table) {
            $table->id();
            $table->string('rfc', 30)->unique();
            $table->string('company_name')->unique();
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('municipality');
            $table->string('state');
            $table->string('country');
            $table->string('cp')->default('N/A');
            $table->string('web_company')->nullable();
            $table->string('bank',50)->default('N/A');
            $table->string('bank_account')->default(0);
            $table->string('bank_account_number')->default(0);
            $table->string('approval_chain',20)->default('normal');  //Especial(es mas corta)
            $table->string('status');
            $table->foreignId('user_request_id')->constrained('users');
            $table->foreignId('user_approve_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_providers');
    }
};
