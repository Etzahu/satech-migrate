<?php

namespace App\Filament\Purchases\Pages\PurchaseRequisition;

use Filament\Infolists;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisition;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Infolists\Components\TextEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class ReviewFlow extends Page implements HasTable
{

    use InteractsWithInfolists;
    use InteractsWithForms;
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'requisiciones-almacen-revisar/{id}';
    protected static string $view = 'filament.purchases.pages.purchase-requisition.review-flow';
    protected static ?string $title = 'Revisión de requisición';
    public $record;

    public function mount($id)
    {
        $this->record = PurchaseRequisition::find($id);

    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Información general')
                            ->schema([
                                TextEntry::make('motive')
                                    ->label('Motivo'),
                                TextEntry::make('folio')
                                    ->label('Folio'),
                                TextEntry::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->date(),
                                TextEntry::make('project.name')
                                    ->label('Proyecto'),
                                TextEntry::make('delivery_address')
                                    ->label('Dirección de entrega'),
                                TextEntry::make('observation')
                                    ->label('Observación adicionales')
                                    ->columnSpan('full'),
                            ])
                            ->columns(3),
                        Tabs\Tab::make('Flujo de aprobación')
                            ->schema([
                                TextEntry::make('approvalChain.reviewer.name')
                                    ->label('Revisa'),
                                TextEntry::make('approvalChain.approver.name')
                                    ->label('Aprueba'),
                            ])
                            ->columns(2),
                        Tabs\Tab::make('Fichas técnicas')
                            ->visible($this->record->getMedia('technical_data_sheets')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        return $record->getMedia('technical_data_sheets');
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('file_name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('Descargar fichas')
                                        ->action(function () {
                                            $downloads = $this->record->getMedia('additional_documents');
                                            return MediaStream::create($this->record->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                        Tabs\Tab::make('Soportes')
                            ->visible($this->record->getMedia('supports')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        return $record->getMedia('technical_data_sheets');
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('file_name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('Descargar fichas')
                                        ->action(function () {
                                            $downloads = $this->record->getMedia('supports');
                                            return MediaStream::create($this->record->folio . '-soportes.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->query()
            ->relationship(fn(): HasMany => $this->record->items())
            ->inverseRelationship('requisition')
            ->columns([
                TextColumn::make('product.name')
                    ->label('Producto')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->searchable(),
                TextColumn::make('observation')
                    ->label('Observación'),
                TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y'),
            ]);
    }
}
