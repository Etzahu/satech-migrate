<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\ViewRecord;
use App\Services\PurchaseRequisitionCreationService;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class ViewPdf extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;
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
