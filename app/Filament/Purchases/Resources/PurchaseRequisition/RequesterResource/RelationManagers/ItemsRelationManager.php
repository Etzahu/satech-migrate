<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Livewire\Attributes\On;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $modelLabel = 'Partida';
    protected static ?string $pluralModelLabel = 'Partidas';
    protected static ?string $navigationLabel = 'Partidas';
    protected static ?string $title = 'Partida';

      #[On('refreshRelationManagerItemsPurchaseRequisition')]
    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->options(function () {
                        $type = $this->getOwnerRecord()->category;
                        return  Product::where('type_purchase', $type)
                            ->where('status', 'aprobado')
                            ->where('company_id', session()->get('company_id'))
                            ->pluck('name', 'id');
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
                Forms\Components\Fieldset::make('Seleccionado')
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
                            ->label('Unidad de Medida')
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
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto'),
                Tables\Columns\TextColumn::make('product.unit.name')
                    ->label('UM'),
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
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];
                        return $data;
                    })
                    ->after(function () {
                        $this->dispatch('refreshOwner');
                    })
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
