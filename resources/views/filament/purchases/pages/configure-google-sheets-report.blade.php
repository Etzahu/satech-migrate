<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center gap-3">
            <x-icon name="si-googlesheets" class="w-8 h-8 text-success-500" />
            <span>Configuración de Exportación Automática</span>
        </div>

        <div>
            Personaliza cómo se exportan las órdenes de compra a tu hoja de Google Sheets.
            Cada vez que se cree o actualice una orden, se sincronizará automáticamente según tu configuración.
        </div>

    </x-filament::section>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="flex gap-3 mt-6">
            <x-filament::button type="submit" color="success" icon="heroicon-o-check" wire:loading.attr="disabled"
                wire:target="save">
                <span wire:loading.remove wire:target="save">Guardar Configuración</span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Guardando...
                </span>
            </x-filament::button>

            <x-filament::button type="button" color="gray" icon="heroicon-o-arrow-path" wire:click="resetToDefaults">
                Restablecer valores por defecto
            </x-filament::button>
        </div>
    </form>

    @if ($config)
        <x-filament::section class="mt-6">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-icon name="heroicon-o-information-circle" class="w-5 h-5" />
                    <span>Información Actual</span>
                </div>
            </x-slot>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</div>
                    <div class="mt-1 text-lg font-semibold">
                        @if ($config->is_active)
                            <span class="text-success-600 dark:text-success-400">✓ Activo</span>
                        @else
                            <span class="text-gray-600 dark:text-gray-400">✗ Inactivo</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Columnas Exportadas</div>
                    <div class="mt-1 text-lg font-semibold">{{ count($config->columns ?? []) }} columnas</div>
                </div>

                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Rango de Fechas</div>
                    <div class="mt-1 text-lg font-semibold">
                        @if ($config->date_range_type === 'days')
                            Últimos {{ $config->days_range }} días
                        @else
                            Personalizado
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-4 mt-4 border border-blue-200 rounded-lg bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-icon name="heroicon-o-information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                            ¿Cómo funciona?
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Cada vez que se cree o actualice una orden de compra, se exportará automáticamente a
                                    tu hoja personal en Google Sheets</li>
                                <li>Solo se exportarán las columnas y el rango de fechas que hayas configurado</li>
                                <li>Tu hoja se llama:
                                    <strong>reporte-ordenes-{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</strong>
                                </li>
                                <li>Puedes desactivar la exportación automática en cualquier momento</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
