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
        Schema::create('provider_evaluation_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_evaluation_id')->constrained('provider_evaluations')->cascadeOnDelete();
            $table->string('question'); // ProviderEvaluationQuestion value
            $table->string('respondent_role'); // solicitante|comprador|almacen
            $table->foreignId('respondent_id')->constrained('users');
            $table->string('selected_option')->nullable();
            $table->unsignedTinyInteger('score')->nullable(); // hidden from users
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->unique(['provider_evaluation_id', 'question'], 'eval_response_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_evaluation_responses');
    }
};
