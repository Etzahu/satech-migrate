<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Storage;
use App\Services\PurchaseRequisitionCreationService;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewPdf extends ViewRecord
{
    protected static string $resource = AuthorizerResource::class;
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PurchaseRequisitionCreationService();
        $service->generatePdf($this->record);
        return $infolist
            ->record($this->record)
            ->schema([
                PdfViewerEntry::make('file')
                    ->label('')
                    ->minHeight('80svh')
                    ->columnSpanFull()
                    ->fileUrl(Storage::url('requisicion-compra.pdf')),
            ]);
    }
}
