<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use App\Models\Product;
use App\Models\PurchaseRequisitionItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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

    /**
     * Coloca al inicio del catálogo los productos que el solicitante de esta
     * requisición ya ha pedido antes, del más reciente al más antiguo, y deja
     * el resto del catálogo después.
     *
     * @param  Collection<int, string>  $options  [product_id => nombre]
     * @return array<int, string>
     */
    protected function sortOptionsByRequesterHistory(Collection $options): array
    {
        $recent = $this->getRequesterRecentProductIds()
            ->filter(fn (int $productId) => $options->has($productId))
            ->mapWithKeys(fn (int $productId) => [$productId => $options->get($productId)]);

        // union conserva el valor de la primera colección cuando la llave se repite,
        // así los recientes quedan arriba y los demás en su orden original.
        return $recent->union($options)->all();
    }

    /**
     * IDs de productos pedidos por el solicitante de esta requisición, sin
     * repetir y del más reciente al más antiguo.
     *
     * @return Collection<int, int>
     */
    protected function getRequesterRecentProductIds(): Collection
    {
        $requesterId = $this->getOwnerRecord()->approvalChain?->requester_id;

        if (blank($requesterId)) {
            return collect();
        }

        return PurchaseRequisitionItem::query()
            ->whereHas('requisition', fn (Builder $query) => $query
                ->where('company_id', session()->get('company_id'))
                ->whereHas('approvalChain', fn (Builder $chain) => $chain->where('requester_id', $requesterId)))
            ->orderByDesc('id')
            ->limit(500)
            ->pluck('product_id')
            ->unique()
            ->values();
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
                        $query = Product::where('status', 'aprobado')
                            ->where('company_id', session()->get('company_id'));

                        if (session()->get('company_id') != 1 && filled($type)) { // ID 1:GPT IM no filtra por tipo
                            $query->where('type_purchase', $type);
                        }

                        return $this->sortOptionsByRequesterHistory($query->pluck('name', 'id'));
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
                     ->modalWidth(Width::SevenExtraLarge)
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
                ->modalWidth(Width::SevenExtraLarge)
                    ->mutateDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];

                        return $data;
                    }),
                Actions\DeleteAction::make(),
            ]);
    }
}
