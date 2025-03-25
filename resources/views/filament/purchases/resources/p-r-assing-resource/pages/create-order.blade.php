<x-filament-panels::page>
    <form wire:submit="create">
        {{ $this->form }}
        <div class="my-6">
            <x-filament::button form="create" type="submit">
                Crear
            </x-filament::button>
        </div>
    </form>
    {{-- @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers
            :active-manager="$this->activeRelationManager"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        />
    @endif --}}
    <x-filament-actions::modals />
</x-filament-panels::page>
