<x-filament-panels::page>
    <div>
        {{-- {{ $this->table }} --}}
    </div>
    <form wire:submit="create">
        {{ $this->form }}
        <div class="my-6">
            <x-filament::button form="create" type="submit">
                Crear
            </x-filament::button>
        </div>
    </form>
    <x-filament-actions::modals />
</x-filament-panels::page>
