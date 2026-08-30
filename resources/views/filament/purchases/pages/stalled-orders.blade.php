<x-filament-panels::page>
    @php($resumen = $this->getResumen())
    @php($filas = $this->getFilas())

    <div class="space-y-6">
        {{-- Resumen: lo que importa es la columna del medio --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <x-filament::section>
                <div class="text-center">
                    <div class="text-4xl font-bold text-gray-700 dark:text-gray-200">{{ $resumen['total'] }}</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">Detenidas</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-600 dark:text-orange-400">{{ $resumen['esperando'] }}</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">Esperando una decisión</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $resumen['comprador'] }}</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">En cancha del comprador</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $resumen['problema'] }}</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">Sin quien pueda responder</div>
                </div>
            </x-filament::section>
        </div>

        <x-filament::section>
            <x-slot name="heading">Órdenes detenidas</x-slot>
            <x-slot name="description">
                Los días se miden desde la última transición de estado, no desde la última edición.
                Cada estado tiene su propio umbral: tres días para los niveles de firma, diez o quince
                para los que están en cancha del comprador.
            </x-slot>

            <div class="mb-4 flex flex-wrap gap-4">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model.live="soloEsperandoDecision"
                        class="rounded border-gray-300 text-primary-600">
                    Solo las que esperan una decisión
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model.live="soloConProblema"
                        class="rounded border-gray-300 text-primary-600">
                    Solo las que nadie puede responder
                </label>
            </div>

            @if ($filas->isEmpty())
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay órdenes detenidas con los filtros seleccionados.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200 text-left dark:border-gray-700">
                            <tr class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <th class="py-2 pr-4">Folio</th>
                                <th class="py-2 pr-4">Estado</th>
                                <th class="py-2 pr-4 text-right">Días</th>
                                <th class="py-2 pr-4">Gerencia</th>
                                <th class="py-2 pr-4">Espera a</th>
                                <th class="py-2">Problema</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($filas as $fila)
                                <tr @class(['bg-red-50/50 dark:bg-red-950/20' => filled($fila['problema'])])>
                                    <td class="py-2 pr-4 font-medium">{{ $fila['folio'] }}</td>
                                    <td class="py-2 pr-4">
                                        {{ $fila['estado'] }}
                                        @if ($fila['esperando_decision'])
                                            <span class="ml-1 rounded bg-orange-100 px-1.5 py-0.5 text-xs text-orange-800 dark:bg-orange-900 dark:text-orange-200">firma</span>
                                        @else
                                            <span class="ml-1 rounded bg-blue-100 px-1.5 py-0.5 text-xs text-blue-800 dark:bg-blue-900 dark:text-blue-200">comprador</span>
                                        @endif
                                    </td>
                                    <td @class([
                                        'py-2 pr-4 text-right font-semibold',
                                        'text-red-600 dark:text-red-400' => $fila['dias'] >= $fila['umbral'] * 3,
                                    ])>
                                        {{ $fila['dias'] }}
                                        <span class="font-normal text-gray-400">/ {{ $fila['umbral'] }}</span>
                                    </td>
                                    <td class="py-2 pr-4">{{ $fila['gerencia'] ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        {{ $fila['responsables'] === [] ? '—' : implode(', ', $fila['responsables']) }}
                                    </td>
                                    <td class="py-2 text-red-600 dark:text-red-400">{{ $fila['problema'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
