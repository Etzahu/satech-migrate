<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;
use App\Services\PurchaseRequisitionCreationService;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class Pdf extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PurchaseRequisitionResource::class;
    protected static string $view = 'filament.purchases.resources.purchase-requisition-resource.pages.pdf';
    protected static ?string $title = 'PDF de la requisición de compra';


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

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
