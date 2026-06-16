<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\RelationManagers;

use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

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

    public function form(Schema $form): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->options(function () {
                        $type = $this->getOwnerRecord()->category;
                        if (session()->get('company_id') == 1) { // ID 1:GPT IM
                            return Product::where('status', 'aprobado')
                                ->where('company_id', session()->get('company_id'))
                                ->pluck('name', 'id');
                        }

                        if (filled($type)) {
                            return Product::where('status', 'aprobado')
                                ->where('company_id', session()->get('company_id'))
                                ->where('type_purchase', $type)
                                ->pluck('name', 'id');
                        } else {
                            return Product::where('status', 'aprobado')
                                ->where('company_id', session()->get('company_id'))
                                ->pluck('name', 'id');
                        }
                    })
                    ->disabled(),
                Forms\Components\Textarea::make('observation')
                    ->label('Observación')
                    ->readonly()
                    ->maxLength(2000),
                Forms\Components\TextInput::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->minValue(1),
                Forms\Components\TextInput::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->default(0)
                    ->maxValue(fn (Get $get) => $get('quantity_requested'))
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
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_purchase')
                    ->label('Cantidad a comprar')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\EditAction::make()
                    ->label('Editar cantidad')
                    ->mutateDataUsing(function (array $data): array {
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
