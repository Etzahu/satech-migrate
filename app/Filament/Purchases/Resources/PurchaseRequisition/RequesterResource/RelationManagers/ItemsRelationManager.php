<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Attributes\On;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $modelLabel = 'Partida';

    protected static ?string $pluralModelLabel = 'Partidas';

    protected static ?string $navigationLabel = 'Partidas';

    protected static ?string $title = 'Partida';

    protected function getItemLabel(): string
    {
        return $this->getOwnerRecord()?->item_label ?? 'Producto';
    }

    #[On('refreshRelationManagerItemsPurchaseRequisition')]
    public function form(Schema $form): Schema
    {
        $itemLabel = $this->getItemLabel();

        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->minValue(1),
                Forms\Components\Select::make('product_id')
                    ->label($itemLabel)
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
                    ->searchable()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        if (filled($get('product_id'))) {
                            $product = Product::find($get('product_id'));
                            $set('selectedCode', $product->code);
                            $set('selectedDesc', $product->name);
                            $set('selectedUm', $product->unit->name);
                        } else {
                            $set('selectedCode', '');
                            $set('selectedDesc', '');
                            $set('selectedUm', '');
                        }
                    }),
                Schemas\Components\Fieldset::make('Seleccionado')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('selectedCode')
                            ->disabled()
                            ->label('Código'),
                        Forms\Components\Textarea::make('selectedDesc')
                            ->disabled()
                            ->label('Descripción'),
                        Forms\Components\TextInput::make('selectedUm')
                            ->disabled()
                            ->label('Unidad de Medida'),
                    ]),
                Forms\Components\Textarea::make('observation')
                    ->label('Observación')
                    ->default('Sin observaciones')
                    ->required()
                    ->maxLength(2000),
            ]);
    }

    public function table(Table $table): Table
    {
        $itemLabel = $this->getItemLabel();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label($itemLabel),
                Tables\Columns\TextColumn::make('product.unit.name')
                    ->label('UM'),
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
                Tables\Columns\TextColumn::make('observation')
                    ->label('Observación')
                    ->words(5),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->slideOver()
                    ->mutateDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];

                        return $data;
                    })
                    ->after(function () {
                        $this->dispatch('refreshOwner');
                    })
                    ->createAnother(false),
            ])
            ->recordActions([
                Actions\EditAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];

                        return $data;
                    }),
                Actions\DeleteAction::make(),
            ]);
    }
}
