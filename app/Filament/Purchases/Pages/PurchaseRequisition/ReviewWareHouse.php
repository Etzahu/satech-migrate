<?php

namespace App\Filament\Purchases\Pages\PurchaseRequisition;

use Livewire\Component;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\PurchaseRequisition;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Infolists\Components\RepeatableEntry;

class ReviewWareHouse extends Page  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $view = 'filament.purchases.pages.purchase-requisition.review-ware-house';
    protected static ?string $title = 'Revisión de almacén';
    protected static ?string $slug = 'requisiciones-almacen-revisar';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected ?string $heading = 'Requisiciones - Revisión de almacén';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;

    public function mount(): void{

    }
    public static function getNavigationBadge(): ?string
    {
        return PurchaseRequisition::query()->reviewWarehouse()->count();
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public  function table(Table $table): Table
    {
        return $table
            ->query(PurchaseRequisition::query()->reviewWarehouse())
            ->columns([
                TextColumn::make('folio')
                    ->searchable(),
                TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('ver')
                ->url(fn (PurchaseRequisition $record): string => route('filament.compras.pages.requisiciones-almacen-revisar.{id}', $record))
            ]);
    }
}
