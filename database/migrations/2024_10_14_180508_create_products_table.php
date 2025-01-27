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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name', 600);
            $table->string('code', 100);
            $table->string('status', 100)->nullable();
            $table->foreignId('company_id')->nullabe()->default(1)->constrained('companies');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('unit_id')->constrained('measure_units');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('category_family_id')->nullable()->constrained('category_families');
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
        Schema::dropIfExists('products');
    }
};
