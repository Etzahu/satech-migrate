<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use App\Services\PurchaseRequisitionCreationService;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class ViewPdf extends ViewRecord
{
    protected static string $resource = ReviewResource::class;
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('folio')
            ]);
        // $service = new PurchaseRequisitionCreationService();
        // $service->generatePdf($this->record);
        // return $infolist
        //     ->record($this->record)
        //     ->schema([
        //         PdfViewerEntry::make('file')
        //             ->label('')
        //             ->minHeight('80svh')
        //             ->columnSpanFull()
        //             ->fileUrl(Storage::url('requisicion-compra.pdf')),
        //     ]);
    }
}
