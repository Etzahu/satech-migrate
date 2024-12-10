<x-filament-panels::page>
    <div>
        <p class="p-0 m-0">
            Partidas de la requisición: <strong>{{ $record->requisition->folio }}</strong>
        </p>
    </div>
    <div>
        {{ $this->table }}
    </div>
</x-filament-panels::page>
