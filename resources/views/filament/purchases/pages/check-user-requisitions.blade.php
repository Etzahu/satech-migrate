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
                                <span>Como Revisor:</span>
                                <span class="font-semibold">{{ $userStats['chains_as_reviewer'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Como Aprobador:</span>
                                <span class="font-semibold">{{ $userStats['chains_as_approver'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Como Autorizador:</span>
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
                            {{ $this->getTotalPendingRequisitions() }}
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Requisiciones Pendientes Total
                        </div>
                        <div class="mt-3 space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span>Para Revisar:</span>
                                <span class="font-semibold">{{ $userStats['pending_to_review'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Para Aprobar:</span>
                                <span class="font-semibold">{{ $userStats['pending_to_approve'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Para Autorizar:</span>
                                <span class="font-semibold">{{ $userStats['pending_to_authorize'] }}</span>
                            </div>
                        </div>
                    </div>
                </x-filament::section>

                {{-- Estado --}}
                <x-filament::section
                    class="{{ $this->getTotalPendingRequisitions() > 0
                        ? 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-950 dark:to-red-900'
                        : 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950 dark:to-green-900' }}">
                    <div class="text-center">
                        <div
                            class="text-2xl font-bold {{ $this->getTotalPendingRequisitions() > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            @if ($this->getTotalPendingRequisitions() > 0)
                                ⚠️ ATENCIÓN
                            @else
                                ✅ SIN PENDIENTES
                            @endif
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            @if ($this->getTotalPendingRequisitions() > 0)
                                Este usuario tiene requisiciones pendientes
                            @else
                                No hay requisiciones pendientes
                            @endif
                        </div>
                        @if ($this->getTotalPendingRequisitions() > 0)
                            <div class="mt-3 text-xs font-medium text-red-700 dark:text-red-300">
                                Debe resolverse antes de dar de baja
                            </div>
                        @endif
                    </div>
                </x-filament::section>
            </div>

            {{-- Detalle de Requisiciones para REVISAR --}}
            @if ($userStats['pending_to_review'] > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <span>📋 Requisiciones para REVISAR</span>
                            <x-filament::badge color="warning">
                                {{ $userStats['pending_to_review'] }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left">Folio</th>
                                    <th class="px-4 py-2 text-left">Solicitante</th>
                                    <th class="px-4 py-2 text-left">Compañía</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                                    <th class="px-4 py-2 text-left">Días Pendiente</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($requisitionsToReview as $req)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 font-mono text-xs">{{ $req->folio }}</td>
                                        <td class="px-4 py-2">{{ $req->approvalChain->requester->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $req->company->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge color="warning">
                                                {{ $req->status }}
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge
                                                color="{{ $req->created_at->diffInDays(now()) > 7 ? 'danger' : 'info' }}">
                                                {{ $req->created_at->diffInDays(now()) }} días
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-1">
                                                {{ ($this->reassignAction)(['requisition' => $req->id]) }}
                                                {{ ($this->createChainAction)(['requisition' => $req->id]) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endif

            {{-- Detalle de Requisiciones para APROBAR --}}
            @if ($userStats['pending_to_approve'] > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <span>✅ Requisiciones para APROBAR</span>
                            <x-filament::badge color="success">
                                {{ $userStats['pending_to_approve'] }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left">Folio</th>
                                    <th class="px-4 py-2 text-left">Solicitante</th>
                                    <th class="px-4 py-2 text-left">Compañía</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                                    <th class="px-4 py-2 text-left">Días Pendiente</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($requisitionsToApprove as $req)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 font-mono text-xs">{{ $req->folio }}</td>
                                        <td class="px-4 py-2">{{ $req->approvalChain->requester->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $req->company->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge color="success">
                                                {{ $req->status }}
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge
                                                color="{{ $req->created_at->diffInDays(now()) > 7 ? 'danger' : 'info' }}">
                                                {{ $req->created_at->diffInDays(now()) }} días
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-1">
                                                {{ ($this->reassignApproveAction)(['requisition' => $req->id]) }}
                                                {{ ($this->createChainApproveAction)(['requisition' => $req->id]) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endif

            {{-- Detalle de Requisiciones para AUTORIZAR --}}
            @if ($userStats['pending_to_authorize'] > 0)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <span>🔐 Requisiciones para AUTORIZAR</span>
                            <x-filament::badge color="primary">
                                {{ $userStats['pending_to_authorize'] }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left">Folio</th>
                                    <th class="px-4 py-2 text-left">Solicitante</th>
                                    <th class="px-4 py-2 text-left">Compañía</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                                    <th class="px-4 py-2 text-left">Días Pendiente</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($requisitionsToAuthorize as $req)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 font-mono text-xs">{{ $req->folio }}</td>
                                        <td class="px-4 py-2">{{ $req->approvalChain->requester->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $req->company->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge color="primary">
                                                {{ $req->status }}
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <x-filament::badge
                                                color="{{ $req->created_at->diffInDays(now()) > 7 ? 'danger' : 'info' }}">
                                                {{ $req->created_at->diffInDays(now()) }} días
                                            </x-filament::badge>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-1">
                                                {{ ($this->reassignAuthorizeAction)(['requisition' => $req->id]) }}
                                                {{ ($this->createChainAuthorizeAction)(['requisition' => $req->id]) }}
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
            @if ($this->getTotalPendingRequisitions() === 0)
                <x-filament::section>
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">✅</div>
                        <div class="text-xl font-semibold text-green-600 dark:text-green-400">
                            Este usuario no tiene requisiciones pendientes
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Participa en {{ $this->getTotalChains() }} cadena(s) de aprobación pero sin solicitudes
                            pendientes actualmente
                        </div>
                    </div>
                </x-filament::section>
            @endif
        @endif

        {{-- Modal de Reasignación --}}
        <x-filament::modal wire:model="showReassignModal" width="2xl">
            <x-slot name="heading">
                Reasignar Requisición
            </x-slot>

            <x-slot name="description">
                Seleccione una cadena de aprobación existente o cree una nueva
            </x-slot>

            <div class="space-y-4">
                @if (count($availableChains) > 0)
                    <div>
                        <label class="block mb-2 text-sm font-medium">Cadenas disponibles para este
                            solicitante:</label>

                        @foreach ($availableChains as $chainId => $chainLabel)
                            <div class="flex items-center gap-2 p-3 mb-2 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800"
                                wire:click="$set('newChainId', {{ $chainId }})">
                                <input type="radio" wire:model="newChainId" value="{{ $chainId }}"
                                    class="text-primary-600">
                                <label class="flex-1 text-sm cursor-pointer">{{ $chainLabel }}</label>
                            </div>
                        @endforeach
                    </div>

                    <x-filament::section class="bg-blue-50 dark:bg-blue-950">
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            💡 <strong>Nota:</strong> Al reasignar, la requisición volverá al estado inicial del proceso
                            de aprobación.
                        </div>
                    </x-filament::section>
                @else
                    <div class="py-6 text-center">
                        <div class="mb-2 text-4xl">⚠️</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            No hay cadenas de aprobación disponibles para este solicitante.
                        </p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Debe crear una nueva cadena de aprobación.
                        </p>
                    </div>
                @endif

                <div class="pt-4 border-t">
                    <x-filament::button wire:click="openCreateChainModal" color="success"
                        icon="heroicon-o-plus-circle" class="w-full">
                        Crear Nueva Cadena de Aprobación
                    </x-filament::button>
                </div>
            </div>

            <x-slot name="footerActions">
                @if (count($availableChains) > 0)
                    <x-filament::button wire:click="reassignRequisition" color="primary" :disabled="!$newChainId">
                        Reasignar y Resetear
                    </x-filament::button>
                @endif

                <x-filament::button wire:click="closeReassignModal" color="gray">
                    Cancelar
                </x-filament::button>
            </x-slot>
        </x-filament::modal>

        {{-- Modal de Crear Cadena --}}
        <x-filament::modal wire:model="showCreateChainModal" width="2xl">
            <x-slot name="heading">
                Crear Nueva Cadena de Aprobación
            </x-slot>

            <x-slot name="description">
                Defina los usuarios que formarán parte de la nueva cadena de aprobación
            </x-slot>

            <form wire:submit="createChainAndReassign">
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium">Revisor</label>
                        <select wire:model="chainData.reviewer_id"
                            class="w-full border-gray-300 rounded-lg dark:border-gray-700 dark:bg-gray-900">
                            <option value="">Seleccione un revisor...</option>
                            @foreach (\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium">Aprobador</label>
                        <select wire:model="chainData.approver_id"
                            class="w-full border-gray-300 rounded-lg dark:border-gray-700 dark:bg-gray-900">
                            <option value="">Seleccione un aprobador...</option>
                            @foreach (\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium">Autorizador</label>
                        <select wire:model="chainData.authorizer_id"
                            class="w-full border-gray-300 rounded-lg dark:border-gray-700 dark:bg-gray-900">
                            <option value="">Seleccione un autorizador...</option>
                            @foreach (\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-filament::section class="bg-yellow-50 dark:bg-yellow-950">
                        <div class="text-sm text-yellow-800 dark:text-yellow-200">
                            ⚠️ <strong>Importante:</strong> Esta cadena se creará para el solicitante de la requisición
                            y luego se reasignará automáticamente.
                        </div>
                    </x-filament::section>
                </div>

                <x-slot name="footerActions">
                    <x-filament::button type="submit" color="success">
                        Crear y Reasignar
                    </x-filament::button>

                    <x-filament::button wire:click="closeCreateChainModal" color="gray" type="button">
                        Cancelar
                    </x-filament::button>
                </x-slot>
            </form>
        </x-filament::modal>

        <x-filament-actions::modals />
    </div>
</x-filament-panels::page>
