<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Storage;
use App\Services\PurchaseRequisitionCreationService;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewPdf extends ViewRecord
{
    protected static string $resource = ReviewerResource::class;
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
