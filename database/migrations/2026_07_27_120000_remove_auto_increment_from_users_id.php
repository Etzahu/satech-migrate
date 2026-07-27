<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * El id de users deja de ser autoincremental: ahora es el "id del colaborador"
     * que se captura manualmente. Sigue siendo la PK (NOT NULL) y conserva sus FKs.
     */
    public function up(): void
    {
        // El id está referenciado por FKs de otras tablas; se desactiva la
        // verificación durante el ALTER. Solo se quita el AUTO_INCREMENT, el
        // tipo y los valores no cambian, así que las FKs siguen siendo válidas.
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
