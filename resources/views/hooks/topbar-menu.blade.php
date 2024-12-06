<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button icon="heroicon-m-building-office-2" color="gray">
        </x-filament::icon-button>
    </x-slot>

    <x-filament::dropdown.list>
        @foreach (App\Models\Company::all() as $company)
            @if (session()->get('company_id') == $company->id)
                <x-filament::dropdown.list.item href="{{ route('company', $company->id) }}" tag="a" color="danger"
                    disabled>
                    {{ $company->short_name }}
                </x-filament::dropdown.list.item>
            @else
                <x-filament::dropdown.list.item href="{{ route('company', $company->id) }}" tag="a">
                    {{ $company->short_name }}
                </x-filament::dropdown.list.item>
            @endif
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
