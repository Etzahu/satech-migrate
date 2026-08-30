<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Nivel informativo de compras: quién ve —sin aprobar— las requisiciones y las
 * órdenes de cada gerencia.
 *
 * Solicitado por Operaciones el 18-ago-2026. El informativo se modela como una
 * tabla de reglas y no como una columna de la cadena de aprobación porque el
 * correo pide dos cosas que una columna no puede expresar:
 *
 *  - El mismo par se repetiría en decenas de cadenas de la misma gerencia.
 *  - Jennifer debe recibir los *servicios* de Manufactura además del titular de
 *    esa gerencia. La categoría vive en la requisición, no en la cadena: las
 *    cadenas vivas de Manufactura mezclan servicio y proveeduría.
 *
 * Regla de resolución: para un documento de gerencia G y categoría C son
 * informativos todos los `user_id` con
 * `management_id = G AND (category IS NULL OR category = C)`.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente: se puede volver a ejecutar sin duplicar nada.
 */
return new class extends Migration
{
    /**
     * Gerencias operativas del correo, con su titular tomado de
     * `management.responsible_id` (verificado el 28-ago-2026: reproduce
     * exactamente los cinco informativos de la tabla de Alan Anaya).
     *
     * MTTOESP → Allan Vázquez · ISW → Jesús Becerra · ING → Jennifer Jarquín
     * MAN → Eddie S. Ordoñez · ST → Iván Ponce
     */
    private const MANAGEMENT_IDS = [13, 8, 9, 5, 10];

    /** Jennifer Martínez Jarquín. */
    private const JENNIFER_USER_ID = 191;

    /** Gerencia De Manufactura. */
    private const MANUFACTURA_MANAGEMENT_ID = 5;

    public function up(): void
    {
        if (! Schema::hasTable('management_informed_rules')) {
            Schema::create('management_informed_rules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('management_id')->constrained('management')->cascadeOnDelete();

                // NULL = todas las categorías. Ojo: en MySQL dos NULL nunca son
                // iguales, así que este índice NO impide duplicados con
                // category NULL; la idempotencia la garantiza rules() abajo.
                $table->enum('category', ['servicio', 'proveeduria'])->nullable();

                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(
                    ['management_id', 'category', 'user_id'],
                    'management_informed_rules_unique'
                );
            });
        }

        foreach ($this->rules() as $rule) {
            $this->insertIfMissing($rule['management_id'], $rule['category'], $rule['user_id']);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('management_informed_rules');
    }

    /**
     * Configuración inicial: cinco reglas base sembradas desde el responsable
     * de cada gerencia, más la regla especial de los servicios de Manufactura.
     *
     * @return array<int, array{management_id: int, category: ?string, user_id: int}>
     */
    private function rules(): array
    {
        $rules = [];

        $responsibles = DB::table('management')
            ->whereIn('id', self::MANAGEMENT_IDS)
            ->pluck('responsible_id', 'id');

        foreach ($responsibles as $managementId => $userId) {
            if (! $userId) {
                continue;
            }

            $rules[] = [
                'management_id' => (int) $managementId,
                'category' => null,
                'user_id' => (int) $userId,
            ];
        }

        // "Para el tema de los servicios que solicita Manufactura (PNDs,
        // maquinados externos, etc.), que estas requisiciones y OC le lleguen a
        // Jennifer a nivel informativo para evitar triangular información."
        // — Alan Anaya, 12-ago-2026. Se suma al titular, no lo reemplaza.
        $rules[] = [
            'management_id' => self::MANUFACTURA_MANAGEMENT_ID,
            'category' => 'servicio',
            'user_id' => self::JENNIFER_USER_ID,
        ];

        return $rules;
    }

    private function insertIfMissing(int $managementId, ?string $category, int $userId): void
    {
        $exists = DB::table('management_informed_rules')
            ->where('management_id', $managementId)
            ->where('user_id', $userId)
            ->when($category === null,
                fn ($query) => $query->whereNull('category'),
                fn ($query) => $query->where('category', $category),
            )
            ->exists();

        if ($exists) {
            return;
        }

        DB::table('management_informed_rules')->insert([
            'management_id' => $managementId,
            'category' => $category,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
