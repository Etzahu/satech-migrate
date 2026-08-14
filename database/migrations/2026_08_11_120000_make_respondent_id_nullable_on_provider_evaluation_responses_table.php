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
        Schema::table('provider_evaluation_responses', function (Blueprint $table) {
            // Las preguntas de un rol compartido (almacén) se crean sin asignar:
            // el primer usuario del rol que responda se queda con la respuesta.
            $table->unsignedBigInteger('respondent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_evaluation_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('respondent_id')->nullable(false)->change();
        });
    }
};
