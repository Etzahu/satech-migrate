<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Formulario de selección --}}
        <x-filament::section>
            <x-slot name="heading">
                Seleccionar Usuario
            </x-slot>

            <form wire:submit.prevent="analyzeUser">
                {{ $this->form }}
            </form>
        </x-filament::section>

        @if ($selectedUserId)
            {{-- Estadísticas generales --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                {{-- Total de Cadenas --}}
                <x-filament::section
                    class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950 dark:to-blue-900">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $this->getTotalChains() }}
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Cadenas de Aprobación Total
                        </div>
                        <div class="mt-3 space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span>Como Aprobador (Gerente):</span>
                                <span class="font-semibold">{{ $userStats['chains_as_approver'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Como Autorizador (DG):</span>
                                <span class="font-semibold">{{ $userStats['chains_as_authorizer'] }}</span>
                            </div>
                        </div>
                    </div>
                </x-filament::section>

                {{-- Total Pendientes --}}
                <x-filament::section
                    class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-950 dark:to-orange-900">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $this->getTotalPendingOrders() }}
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Órdenes de Compra Pendientes
                        </div>
                        <div class="mt-3 space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span>Para Aprobar:</span>
                                <span class="font-semibold">{{ $userStats['pending_orders_to_approve'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Para Autorizar:</span>
                                <span class="font-semibold">{{ $userStats['pending_orders_to_authorize'] }}</span>
                            </div>
                        </div>
                    </div>
                </x-filament::section>

                {{-- Estado --}}
                <x-filament::section
                    class="{{ $this->getTotalPendingOrders() > 0
                        ? 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-950 dark:to-red-900'
                        : 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950 dark:to-green-900' }}">
                    <div class="text-center">
                        <div
                            class="text-2xl font-bold {{ $this->getTotalPendingOrders() > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            @if ($this->getTotalPendingOrders() > 0)
                                ⚠️ ATENCIÓN
                            @else
                                ✅ SIN PENDIENTES
                            @endif
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            @if ($this->getTotalPendingOrders() > 0)
                                Este usuario tiene órdenes de compra pendientes
                            @else
                                No hay órdenes de compra pendientes
                            @endif
                        </div>
                        @if ($this->getTotalPendingOrders() > 0)
                            <div class="mt-3 text-xs font-medium text-red-700 dark:text-red-300">
                                Debe reasignarse antes de dar de baja al usuario
                            </div>
                        @endif
                    </div>
                </x-filament::section>
            </div>

            {{-- Detalle de Órdenes de Compra para APROBAR --}}
            @if ($userStats['pending_orders_to_approve'] > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <span>🛒 Órdenes de Compra para APROBAR (Gerente Solicitante)</span>
                            <x-filament::badge color="success">
                                {{ $userStats['pending_orders_to_approve'] }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left">Folio OC</th>
                                    <th class="px-4 py-2 text-left">Requisición</th>
                                    <th class="px-4 py-2 text-left">Proveedor</th>
                                    <th class="px-4 py-2 text-left">Comprador</th>
                                    <th class="px-4 py-2 text-left">Compañía</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                                    <th class="px-4 py-2 text-left">Días Pendiente</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($ordersToApprove as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 font-mono text-xs font-semibold">{{ $order->folio }}</td>
                                        <td class="px-4 py-2 font-mono text-xs">
                                            {{ $order->requisition->folio ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-xs">{{ $order->provider->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $order->purchaser->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $order->company->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge color="success">
                                                {{ $order->status }}
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge
                                                color="{{ $order->created_at->diffInDays(now()) > 7 ? 'danger' : 'info' }}">
                                                {{ $order->created_at->diffInDays(now()) }} días
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                {{ ($this->reassignOrderRequisitionChainAction)(['order' => $order->id]) }}
                                                {{ ($this->createChainForOrderAction)(['order' => $order->id]) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endif

            {{-- Detalle de Órdenes de Compra para AUTORIZAR --}}
            @if ($userStats['pending_orders_to_authorize'] > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <span>🔐 Órdenes de Compra para AUTORIZAR (Dirección General)</span>
                            <x-filament::badge color="primary">
                                {{ $userStats['pending_orders_to_authorize'] }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left">Folio OC</th>
                                    <th class="px-4 py-2 text-left">Requisición</th>
                                    <th class="px-4 py-2 text-left">Proveedor</th>
                                    <th class="px-4 py-2 text-left">Comprador</th>
                                    <th class="px-4 py-2 text-left">Compañía</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                                    <th class="px-4 py-2 text-left">Días Pendiente</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($ordersToAuthorize as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 font-mono text-xs font-semibold">{{ $order->folio }}</td>
                                        <td class="px-4 py-2 font-mono text-xs">
                                            {{ $order->requisition->folio ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-xs">{{ $order->provider->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $order->purchaser->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $order->company->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge color="primary">
                                                {{ $order->status }}
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge
                                                color="{{ $order->created_at->diffInDays(now()) > 7 ? 'danger' : 'info' }}">
                                                {{ $order->created_at->diffInDays(now()) }} días
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                {{ ($this->reassignOrderRequisitionChainAction)(['order' => $order->id]) }}
                                                {{ ($this->createChainForOrderAction)(['order' => $order->id]) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endif

            {{-- Mensaje cuando no hay pendientes --}}
            @if ($this->getTotalPendingOrders() === 0)
                <x-filament::section>
                    <div class="py-12 text-center">
                        <div class="mb-4 text-6xl">✅</div>
                        <div class="text-xl font-semibold text-green-600 dark:text-green-400">
                            Este usuario no tiene órdenes de compra pendientes
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Participa en {{ $this->getTotalChains() }} cadena(s) de aprobación pero sin órdenes
                            pendientes actualmente
                        </div>
                    </div>
                </x-filament::section>
            @endif
        @endif

        <x-filament-actions::modals />
    </div>
</x-filament-panels::page>
