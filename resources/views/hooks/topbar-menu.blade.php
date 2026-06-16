@php
    $companies = \App\Models\Company::all();
    $currentCompanyId = session()->get('company_id');
    $currentCompany = $companies->firstWhere('id', $currentCompanyId);
@endphp

<x-filament::dropdown placement="bottom-start" width="xs">
    <x-slot name="trigger">
        <button
            type="button"
            class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-start transition duration-75 hover:bg-gray-100 dark:hover:bg-white/5"
        >
            @if ($currentCompany)
                <span class="relative flex h-2.5 w-2.5 shrink-0">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-violet-500 opacity-75"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-violet-600"></span>
                </span>
            @endif

            <span class="flex flex-col leading-tight">
                <span class="text-xs text-gray-500 dark:text-gray-400">Empresa actual</span>
                <span class="text-sm font-semibold text-gray-950 dark:text-white">
                    {{ $currentCompany?->short_name ?? 'Seleccionar empresa' }}
                </span>
            </span>

            <x-filament::icon
                icon="heroicon-m-chevron-down"
                class="h-4 w-4 shrink-0 text-gray-400 dark:text-gray-500"
            />
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        @foreach ($companies as $company)
            <x-filament::dropdown.list.item
                tag="a"
                :href="route('company', $company->id)"
                :icon="$currentCompanyId == $company->id ? 'heroicon-m-check-circle' : 'heroicon-m-building-office-2'"
                :color="$currentCompanyId == $company->id ? 'success' : 'gray'"
            >
                {{ $company->short_name }}
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
