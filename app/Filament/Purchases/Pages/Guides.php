<?php

namespace App\Filament\Purchases\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Guides extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected string $view = 'filament.purchases.pages.guides';

    protected static ?string $navigationLabel = 'Guías de uso';

    protected static ?string $title = 'Guías de uso';

    protected static ?int $navigationSort = 1;

    /**
     * Lista completa de guías.
     *
     * El campo `roles` indica qué roles pueden ver cada guía.
     * Un array vacío significa que la guía es visible para todos.
     * `super_admin` siempre ve todas las guías.
     *
     * Para agregar un video coloca el archivo en storage/app/public/guides/
     * y actualiza el campo `video` con el nombre del archivo (ej: 'crear-requisicion.mp4').
     *
     * Para agregar un PDF coloca el archivo en storage/app/public/guides/
     * y actualiza el campo `pdf` con el nombre del archivo (ej: 'guia-requisiciones.pdf').
     */
    protected function allGuides(): array
    {
        return [
            [
                'slug' => 'crear-requisicion',
                'title' => 'Crear una requisición',
                'description' => 'Paso a paso para registrar una nueva solicitud de compra, adjuntar fichas técnicas y enviarla al flujo de aprobación.',
                'icon' => 'heroicon-o-document-plus',
                'color' => 'amber',
                'video' => '1.mp4',
                'pdf' => null,
                'roles' => ['solicita_requisicion_compra', 'gerente_solicitante_orden_compra'],
            ],
            [
                'slug' => 'alta-productos-proyectos',
                'title' => 'Alta de productos, servicios y proyectos',
                'description' => 'Cómo solicitar el registro de un nuevo producto, servicio o proyecto cuando no existe en el catálogo del sistema.',
                'icon' => 'heroicon-o-plus-circle',
                'color' => 'green',
                'video' => null,
                'pdf' => 'guia-solicitante-alta-productos-proyectos.pdf',
                'roles' => ['solicita_requisicion_compra'],
            ],
            [
                'slug' => 'crear-orden-compra',
                'title' => 'Crear una orden de compra',
                'description' => 'Cómo generar una orden a partir de una requisición aprobada, capturar partidas, cotización, condiciones de pago, flujos de aprobación normal y especial.',
                'icon' => 'heroicon-o-shopping-cart',
                'color' => 'blue',
                'video' => null,
                'pdf' => 'guia-orden-de-compra.pdf',
                'roles' => ['comprador', 'administrador_compras', 'gerente_compras',
                    'gerente_solicitante_orden_compra', 'autoriza_nivel-1-orden_compra',
                    'autoriza_nivel-2-orden_compra'],
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
                    'gerente_compras',
                    'administrador_compras',
                ],
            ],
            [
                'slug' => 'flujo-aprobacion',
                'title' => 'Flujo de aprobación',
                'description' => 'Diagramas visuales del flujo completo: Requisición de Compra (7 estados, devoluciones) y Orden de Compra (flujo normal con bifurcación de monto y flujo especial).',
                'icon' => 'heroicon-o-arrow-path',
                'color' => 'indigo',
                'video' => null,
                'pdf' => 'guia-flujo-aprobacion.pdf',
                'roles' => [], // visible para todos
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
     * Retorna solo las guías que el usuario autenticado puede ver,
     * según sus roles. super_admin siempre ve todo.
     */
    public function getGuides(): array
    {
        return $this->allGuides();
        $user = Auth::user();
        if ($user->hasRole('super_admin')) {
            return $this->allGuides();
        }
        return array_values(
            array_filter(
                $this->allGuides(),
                fn (array $guide) => empty($guide['roles']) || $user->hasAnyRole($guide['roles'])
            )
        );
    }
}
