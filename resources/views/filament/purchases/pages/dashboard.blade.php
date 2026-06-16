<x-filament-panels::page>
    <div class="space-y-8">

        {{-- ── Bienvenida ─────────────────────────────────────────────────── --}}
        <div
            class="relative p-8 overflow-hidden shadow-lg rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-orange-500">
            <div class="relative z-10">
                <h1 class="mt-1 text-3xl font-bold text-white">
                    Bienvenido/a, {{ auth()->user()->name }} 👋
                </h1>
                <p class="mt-2 text-amber-100">
                    Aquí encontrarás guías de uso y las últimas novedades del sistema.
                </p>
            </div>
            {{-- Decoración de fondo --}}
            <div class="absolute w-48 h-48 rounded-full -right-10 -top-10 bg-white/10"></div>
            <div class="absolute w-32 h-32 rounded-full -bottom-8 right-24 bg-white/10"></div>
        </div>

        {{-- ── Novedades ───────────────────────────────────────────────────── --}}
        <div>
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900">
                    <x-heroicon-o-sparkles class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                </span>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Novedades del sistema</h2>
                <span
                    class="ml-2 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                    Mayo 2026
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- Novedad 1: Tiempos de entrega --}}
                <div
                    class="relative p-6 overflow-hidden transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 shrink-0 rounded-xl bg-blue-50 dark:bg-blue-900/30">
                            <x-heroicon-o-calendar-days class="w-6 h-6 text-blue-500" />
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                                    Fechas de entrega automáticas
                                </h3>
                                <span
                                    class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700 dark:bg-green-900 dark:text-green-300">
                                    Nuevo
                                </span>
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                Ya no es necesario seleccionar una fecha de entrega al crear la orden. Ahora solo se
                                indica
                                <strong class="text-gray-700 dark:text-gray-200">cuántos días</strong> necesita el
                                proveedor
                                para entregar. Cuando la orden sea autorizada, el sistema calculará la fecha de entrega
                                automáticamente a partir de ese momento.
                            </p>
                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                Esto elimina los desfases causados por los tiempos de aprobación.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Novedad 2: Evaluaciones de proveedor --}}
                <div
                    class="relative p-6 overflow-hidden transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 shrink-0 rounded-xl bg-purple-50 dark:bg-purple-900/30">
                            <x-heroicon-o-star class="w-6 h-6 text-purple-500" />
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                                    Módulo de evaluación de proveedores
                                </h3>
                                <span
                                    class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700 dark:bg-green-900 dark:text-green-300">
                                    Nuevo
                                </span>
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                Al autorizarse una orden, el sistema genera automáticamente una
                                <strong class="text-gray-700 dark:text-gray-200">evaluación del proveedor</strong>.
                                El solicitante, el comprador y almacén responden preguntas según su rol.
                                Los resultados quedan registrados con una puntuación para llevar un historial de
                                desempeño.
                            </p>
                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                También puede generarse manualmente desde el detalle de cualquier orden (solo
                                administradores y gerente de compras).
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Guías de uso ────────────────────────────────────────────────── --}}
        <div>
            <div class="flex items-center justify-between gap-2 mb-4">
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg dark:bg-gray-700">
                        <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                    </span>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Guías de uso</h2>
                </div>
                <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                    class="flex items-center gap-1.5 text-sm font-medium text-amber-600 transition hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                    Ver todas las guías
                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-amber-50 dark:bg-amber-900/30">
                            <x-heroicon-o-document-plus class="w-5 h-5 text-amber-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Crear una requisición</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Paso a paso para registrar una nueva solicitud de compra, adjuntar fichas técnicas y enviarla al
                        flujo de aprobación.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-blue-50 dark:bg-blue-900/30">
                            <x-heroicon-o-shopping-cart class="w-5 h-5 text-blue-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Crear una orden de compra</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Cómo generar una orden a partir de una requisición aprobada, capturar partidas, cotización y
                        condiciones de entrega.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-green-50 dark:bg-green-900/30">
                            <x-heroicon-o-star class="w-5 h-5 text-green-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Evaluar a un proveedor</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Instrucciones para responder las preguntas de evaluación después de que una orden de compra haya
                        sido completada.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-orange-50 dark:bg-orange-900/30">
                            <x-heroicon-o-building-storefront class="w-5 h-5 text-orange-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Registrar un proveedor</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Cómo dar de alta un nuevo proveedor, capturar sus datos fiscales, contactos y enviar para su
                        aprobación.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-rose-50 dark:bg-rose-900/30">
                            <x-heroicon-o-check-badge class="w-5 h-5 text-rose-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Aprobar una orden</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Guía para revisores y aprobadores: cómo revisar el detalle de una orden, validar documentos y
                        emitir una respuesta.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

                <div
                    class="flex flex-col p-5 transition bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-amber-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-600">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg shrink-0 bg-indigo-50 dark:bg-indigo-900/30">
                            <x-heroicon-o-arrow-path class="w-5 h-5 text-indigo-500" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Flujo de aprobación</h3>
                    </div>
                    <p class="flex-1 mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Diagrama y explicación del recorrido que sigue una orden desde que se crea hasta que es enviada
                        al proveedor.
                    </p>
                    <a href="{{ \App\Filament\Purchases\Pages\Guides::getUrl() }}"
                        class="flex items-center gap-1 mt-4 text-xs font-medium transition text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                        <x-heroicon-o-play-circle class="w-4 h-4" />
                        <span>Ver guía</span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-filament-panels::page>
