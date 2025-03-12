<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseRequisitionItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $modelLabel = 'Partida';
    protected static ?string $pluralModelLabel = 'Partidas';
    protected static ?string $navigationLabel = 'Partidas';
    protected static ?string $title = 'Partida';
    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->options(Product::where('status', 'aprobado')->where('company_id', session()->get('company_id'))->pluck('name', 'id'))
                    ->disabled(),
                Forms\Components\Textarea::make('observation')
                    ->label('Observación')
                    ->readonly()
                    ->maxLength(2000),
                Forms\Components\TextInput::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->readonly()
                    ->minValue(1),
                Forms\Components\TextInput::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->maxValue(fn(Get $get) => $get('quantity_requested'))
                    ->minValue(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto'),
                Tables\Columns\TextColumn::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_purchase')
                    ->label('Cantidad a comprar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar cantidad')
                    ->mutateFormDataUsing(function (array $data): array {
                        if ($data['quantity_warehouse'] > 0) {
                            $data['quantity_purchase'] = $data['quantity_requested'] - $data['quantity_warehouse'];
                        }
                        $data['user_warehouse_id'] = auth()->id();
                        return $data;
                    })
                    ->successNotificationTitle('Cantidad actualizada correctamente'),
            ]);
    }
}
