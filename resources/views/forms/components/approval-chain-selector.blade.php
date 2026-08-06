<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
        class="fi-fo-approval-chain-selector overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10"
    >
        <table class="w-full text-start text-sm">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="w-10 px-3 py-2"></th>
                    <th class="px-3 py-2 text-start font-medium text-gray-600 dark:text-gray-300">Revisa</th>
                    <th class="px-3 py-2 text-start font-medium text-gray-600 dark:text-gray-300">Aprueba</th>
                    <th class="px-3 py-2 text-start font-medium text-gray-600 dark:text-gray-300">Autoriza</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($getChains() as $chain)
                    @php
                        $reason = $chain->unavailabilityReason();
                        $available = blank($reason) && ! $isDisabled();
                    @endphp
                    <tr
                        class="border-t border-gray-200 dark:border-white/10 {{ $available ? 'cursor-pointer transition-colors hover:bg-gray-50 dark:hover:bg-white/5' : 'bg-gray-50/60 opacity-70 dark:bg-white/5' }}"
                        @if ($available)
                            x-on:click="state = {{ $chain->id }}"
                            x-bind:class="state == {{ $chain->id }} ? 'bg-primary-50 dark:bg-primary-500/10' : ''"
                        @endif
                    >
                        <td class="px-3 py-2">
                            <x-filament::input.radio
                                x-model.number="state"
                                value="{{ $chain->id }}"
                                :disabled="! $available"
                            />
                        </td>
                        <td class="px-3 py-2">{{ $chain->reviewer?->name ?? 'Usuario eliminado' }}</td>
                        <td class="px-3 py-2">{{ $chain->approver?->name ?? 'Usuario eliminado' }}</td>
                        <td class="px-3 py-2">{{ $chain->authorizer?->name ?? 'Usuario eliminado' }}</td>
                    </tr>

                    @if (filled($reason))
                        <tr class="{{ $available ? '' : 'bg-gray-50/60 dark:bg-white/5' }}">
                            <td></td>
                            <td colspan="3" class="px-3 pb-2">
                                <p class="flex items-start gap-1 text-xs text-danger-600 dark:text-danger-400">
                                    <x-filament::icon icon="heroicon-m-exclamation-triangle" class="mt-px h-4 w-4 shrink-0" />
                                    <span>{{ $reason }} Seleccione otro flujo para poder guardar.</span>
                                </p>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4" class="px-3 py-4 text-center text-gray-500 dark:text-gray-400">
                            No hay flujos de aprobación disponibles. Solicite al administrador que le asigne una cadena.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-dynamic-component>
