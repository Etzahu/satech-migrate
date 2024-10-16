<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button icon="heroicon-m-building-office-2" color="gray">
        </x-filament::icon-button>
    </x-slot>

    <x-filament::dropdown.list>
        @if (session()->get('company_id') == 1)
        <x-filament::dropdown.list.item href="{{ route('company',1) }}" tag="a" color="danger">
            GPT
        </x-filament::dropdown.list.item>
        @else
        <x-filament::dropdown.list.item href="{{ route('company',1) }}" tag="a" >
            GPT
        </x-filament::dropdown.list.item>
        @endif
        @if (session()->get('company_id') == 2)
        <x-filament::dropdown.list.item href="{{ route('company',2) }}" tag="a" color="danger">
            TECHENERGY
        </x-filament::dropdown.list.item>
        @else
        <x-filament::dropdown.list.item href="{{ route('company',2) }}" tag="a" >
            TECHENERGY
        </x-filament::dropdown.list.item>
        @endif
    </x-filament::dropdown.list>
</x-filament::dropdown>
