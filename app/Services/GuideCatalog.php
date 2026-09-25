<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

/**
 * Catálogo de guías de uso del sistema.
 *
 * Es la única lista: la página «Guías de uso» la muestra y la invitación por
 * correo la usa para decidir qué adjuntar. Agregar una guía aquí la publica en
 * ambos lados sin tocar nada más.
 *
 * `roles` indica quién la necesita; un arreglo vacío significa que aplica a
 * todos. Ese mismo campo es el que divide la invitación por tipo de usuario:
 * a un comprador se le propone la guía de órdenes y a un solicitante la de
 * requisiciones, sin mantener dos mapeos distintos.
 *
 * @phpstan-type Guia array{slug: string, title: string, description: string, icon: string, color: string, video: ?string, pdf: ?string, roles: array<int, string>}
 */
class GuideCatalog
{
    /**
     * Carpeta de las guías dentro del disco `public`.
     */
    protected const DIRECTORIO = 'guides';

    /**
     * Lista completa de guías.
     *
     * Para agregar un video coloca el archivo en storage/app/public/guides/
     * y escribe su nombre en `video` (ej: 'crear-requisicion.mp4').
     *
     * Para agregar un PDF coloca el archivo en storage/app/public/guides/
     * y escribe su nombre en `pdf` (ej: 'guia-requisiciones.pdf').
     *
     * @return array<int, Guia>
     */
    public function all(): array
    {
        return [
            [
                'slug' => 'crear-requisicion',
                'title' => 'Crear una requisición',
                'description' => 'Guía completa del solicitante: los tres requisitos para poder generarla (rol, gerencia y cadena de aprobación), cómo influye la empresa seleccionada, captura campo por campo, partidas, envío, recorrido de aprobación, estados y solución de problemas.',
                'icon' => 'heroicon-o-document-plus',
                'color' => 'amber',
                'video' => null,
                'pdf' => 'guia-solicitante-requisiciones.pdf',
                'roles' => ['solicita_requisicion_compra', 'gerente_solicitante_orden_compra'],
            ],
            [
                'slug' => 'alta-productos-proyectos',
                'title' => 'Alta de productos, servicios y proyectos',
                'description' => 'Cómo solicitar el registro de un producto, servicio o proyecto que no existe todavía: campos, documentación que acelera la aprobación, cómo influye la empresa seleccionada, estados y los avisos que recibes.',
                'icon' => 'heroicon-o-plus-circle',
                'color' => 'green',
                'video' => null,
                'pdf' => 'guia-solicitante-alta-productos-proyectos.pdf',
                'roles' => ['solicita_requisicion_compra'],
            ],
            [
                'slug' => 'crear-orden-compra',
                'title' => 'Crear una orden de compra',
                'description' => 'Guía completa del comprador: los dos caminos de aprobación, quién firma por cadena y quién por rol, captura campo por campo, partidas y precios, la liberación de Dirección Administrativa, cuándo se activa el nivel de monto, reapertura y solución de problemas.',
                'icon' => 'heroicon-o-shopping-cart',
                'color' => 'blue',
                'video' => null,
                'pdf' => 'guia-orden-de-compra.pdf',
                'roles' => ['comprador', 'administrador_compras', 'gerente_compras',
                    'gerente_solicitante_orden_compra', 'autoriza_nivel-1-orden_compra',
                    'autoriza_nivel-2-orden_compra', 'aprueba_orden_compra',
                    'autoriza_orden_compra', 'libera_orden_compra', 'informativo_compras'],
            ],
            [
                'slug' => 'evaluar-proveedor',
                'title' => 'Evaluar a un proveedor',
                'description' => 'Guía completa del módulo de evaluación: cómo activarla, quién responde, preguntas por tipo (proveeduría/servicio), puntajes y cómo ver resultados.',
                'icon' => 'heroicon-o-star',
                'color' => 'amber',
                'video' => null,
                'pdf' => 'guia-evaluacion-proveedor.pdf',
                'roles' => [], // visible para todos los roles
            ],
            [
                'slug' => 'registrar-proveedor',
                'title' => 'Registrar un proveedor',
                'description' => 'Cómo dar de alta un nuevo proveedor, capturar sus datos fiscales, contactos y enviar para su aprobación.',
                'icon' => 'heroicon-o-building-storefront',
                'color' => 'orange',
                'video' => null,
                'pdf' => null,
                'roles' => ['comprador', 'administrador_compras', 'gerente_compras'],
            ],
            [
                'slug' => 'aprobar-orden',
                'title' => 'Aprobar una orden',
                'description' => 'Guía para revisores y aprobadores: cómo revisar el detalle de una orden, validar documentos y emitir una respuesta.',
                'icon' => 'heroicon-o-check-badge',
                'color' => 'rose',
                'video' => null,
                'pdf' => null,
                'roles' => [
                    'gerente_solicitante_orden_compra',
                    'autoriza_nivel-1-orden_compra',
                    'autoriza_nivel-2-orden_compra',
                    'aprueba_orden_compra',
                    'autoriza_orden_compra',
                    'libera_orden_compra',
                    'gerente_compras',
                    'administrador_compras',
                ],
            ],
            [
                'slug' => 'flujo-aprobacion',
                'title' => 'Flujo de aprobación',
                'description' => 'El recorrido completo de los dos documentos: cada estado de la requisición y de la orden de compra, quién actúa en él, qué puede hacer y qué correo dispara. Incluye devoluciones, cancelaciones y casos especiales.',
                'icon' => 'heroicon-o-arrow-path',
                'color' => 'indigo',
                'video' => null,
                'pdf' => 'guia-flujo-aprobacion.pdf',
                'roles' => [], // visible para todos
            ],
            [
                'slug' => 'cadena-requisicion',
                'title' => 'Administración: Cadenas de aprobación',
                'description' => 'Cómo armar las cadenas de las que depende todo el módulo de requisiciones: quién ocupa cada nivel, cuándo dejar vacío el de autorización, qué hacer cuando un firmante deja la empresa y cómo destrabar las requisiciones detenidas.',
                'icon' => 'heroicon-o-link',
                'color' => 'rose',
                'video' => null,
                'pdf' => 'guia-admin-cadena-requisicion.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],

            // ── Guías de Administración ──────────────────────────────────────
            [
                'slug' => 'admin-categorias',
                'title' => 'Administración: Categorías y Familias',
                'description' => 'Cómo crear y gestionar categorías y sus familias para organizar el catálogo de productos y servicios.',
                'icon' => 'heroicon-o-tag',
                'color' => 'indigo',
                'video' => null,
                'pdf' => 'guia-admin-categorias.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-gerencias',
                'title' => 'Administración: Gerencias',
                'description' => 'Cómo crear gerencias, asignar responsables y configurar restricciones de proyectos por área.',
                'icon' => 'heroicon-o-building-office-2',
                'color' => 'blue',
                'video' => null,
                'pdf' => 'guia-admin-gerencias.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-catalogo',
                'title' => 'Administración: Catálogo',
                'description' => 'Cómo crear productos y servicios, aprobar solicitudes de alta del catálogo y gestionar el estatus de cada elemento.',
                'icon' => 'heroicon-o-squares-2x2',
                'color' => 'green',
                'video' => null,
                'pdf' => 'guia-admin-catalogo.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-proyectos',
                'title' => 'Administración: Proyectos',
                'description' => 'Cómo registrar proyectos, aprobar solicitudes de alta y activar o inactivar proyectos en el sistema.',
                'icon' => 'heroicon-o-briefcase',
                'color' => 'amber',
                'video' => null,
                'pdf' => 'guia-admin-proyectos.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-proveedores',
                'title' => 'Administración: Proveedores',
                'description' => 'Cómo registrar proveedores, gestionar datos fiscales, bancarios, contactos y la cadena de aprobación (normal vs especial).',
                'icon' => 'heroicon-o-truck',
                'color' => 'orange',
                'video' => null,
                'pdf' => 'guia-admin-proveedores.pdf',
                'roles' => ['gerente_compras', 'administrador_compras', 'comprador'],
            ],
            [
                'slug' => 'admin-usuarios',
                'title' => 'Administración: Usuarios',
                'description' => 'Cómo crear usuarios, asignar gerencia y roles, activar o desactivar cuentas y usar la función de impersonación.',
                'icon' => 'heroicon-o-users',
                'color' => 'rose',
                'video' => null,
                'pdf' => 'guia-admin-usuarios.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-marcas-unidades',
                'title' => 'Administración: Marcas y Unidades de Medida',
                'description' => 'Cómo gestionar el catálogo de marcas de productos y las unidades de medida disponibles en el sistema.',
                'icon' => 'heroicon-o-rectangle-stack',
                'color' => 'indigo',
                'video' => null,
                'pdf' => 'guia-admin-marcas-unidades.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
            [
                'slug' => 'admin-restaurar-ordenes',
                'title' => 'Administración: Restaurar órdenes de compra',
                'description' => 'Cómo recuperar órdenes eliminadas desde la pestaña Borradas del módulo de Administración y notificar automáticamente al comprador asignado.',
                'icon' => 'heroicon-o-arrow-uturn-left',
                'color' => 'green',
                'video' => null,
                'pdf' => 'guia-admin-restaurar-ordenes.pdf',
                'roles' => ['gerente_compras', 'administrador_compras'],
            ],
        ];
    }

    /**
     * Una guía por su slug.
     *
     * @return Guia|null
     */
    public function find(string $slug): ?array
    {
        foreach ($this->all() as $guide) {
            if ($guide['slug'] === $slug) {
                return $guide;
            }
        }

        return null;
    }

    /**
     * Guías que corresponden a los roles del usuario.
     *
     * Una guía sin roles aplica a cualquiera. `super_admin` no se trata como
     * caso especial: quien tiene todos los roles ya empata con todas.
     *
     * @return array<int, Guia>
     */
    public function forUser(User $user): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $guide) => empty($guide['roles']) || $user->hasAnyRole($guide['roles'])
        ));
    }

    /**
     * Guías cuyo PDF existe realmente en disco.
     *
     * El catálogo lista guías que todavía no tienen documento; adjuntar una de
     * esas dejaría el correo sin el archivo prometido.
     *
     * @return array<int, Guia>
     */
    public function withPdf(): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $guide) => filled($guide['pdf']) && $this->pdfExists($guide['pdf'])
        ));
    }

    /**
     * Opciones [slug => título] de las guías adjuntables.
     *
     * @return array<string, string>
     */
    public function pdfOptions(): array
    {
        $options = [];

        foreach ($this->withPdf() as $guide) {
            $options[$guide['slug']] = $guide['title'];
        }

        return $options;
    }

    /**
     * Slugs adjuntables que le tocan al usuario por sus roles.
     *
     * Es lo que la invitación deja premarcado: la división por tipo sale del
     * mismo mapeo que usa la página de guías.
     *
     * @return array<int, string>
     */
    public function suggestedFor(User $user): array
    {
        $suggested = [];

        foreach ($this->forUser($user) as $guide) {
            if (filled($guide['pdf']) && $this->pdfExists($guide['pdf'])) {
                $suggested[] = $guide['slug'];
            }
        }

        return $suggested;
    }

    /**
     * Ruta absoluta del PDF de una guía, o null si no está en disco.
     */
    public function pdfPath(string $slug): ?string
    {
        $guide = $this->find($slug);

        if (blank($guide['pdf'] ?? null) || ! $this->pdfExists($guide['pdf'])) {
            return null;
        }

        return Storage::disk('public')->path(self::DIRECTORIO.'/'.$guide['pdf']);
    }

    protected function pdfExists(string $archivo): bool
    {
        return Storage::disk('public')->exists(self::DIRECTORIO.'/'.$archivo);
    }
}
