<?php

// namespace App\Filament\Purchases\Resources\PurchaserResource\RelationManagers;
namespace App\Filament\Purchases\Resources\PurchaseResource\PurchaserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Pelmered\FilamentMoneyField\MoneyFormatter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $modelLabel = 'Partida';
    protected static ?string $pluralModelLabel = 'Partidas';
    protected static ?string $navigationLabel = 'Partidas';
    protected static ?string $title = 'Partidas';

    #[On('refreshRelationManagerItems')]
    public function refresh(): void {}
    public function form(Form $form): Form
    {
        $component = [];
        if ($this->getOwnerRecord()->currency == 'MXN') {
            $component = [
                MoneyInput::make('unit_price')
                    ->label('Precio unitario')
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->required()
                    ->minValue(0)
                    ->afterStateHydrated(function ($component,  $state) {
                        if (is_null($state)) {
                            return null;
                        }
                        if (! is_numeric($state)) {
                            return $state;
                        }
                        if ($state == 0) {
                            return 0;
                        }
                        $component->state($state / 100);
                    })
                    ->numeric()
            ];
        }
        if ($this->getOwnerRecord()->currency == 'USD') {
            $component =  [MoneyInput::make('unit_price')
                ->label('Precio unitario')
                ->currency('USD')
                ->locale('en_US')
                ->required()
                ->minValue(0)
                ->afterStateHydrated(function ($component,  $state) {
                    if (is_null($state)) {
                        return null;
                    }
                    if (! is_numeric($state)) {
                        return $state;
                    }
                    if ($state == 0) {
                        return 0;
                    }
                    $component->state($state / 100);
                })
                ->numeric()];
        }

        $components =  [
            Forms\Components\TextInput::make('quantity')
                ->label('Cantidad')
                ->required()
                ->minValue(0)
                ->integer(),
            Forms\Components\Select::make('product_id')
                ->label('Producto/Servicio')
                ->options(function () {
                    $type = $this->getOwnerRecord()->requisition->category;
                    if (filled($type)) {
                        return  Product::where('type_purchase', $type)
                            ->where('status', 'aprobado')
                            ->where('company_id', session()->get('company_id'))
                            ->pluck('name', 'id');
                    } else {
                        return  Product::where('status', 'aprobado')
                            ->where('company_id', session()->get('company_id'))
                            ->pluck('name', 'id');
                    }
                })
                ->searchPrompt('Busca los productos o servicios por su descripción')
                ->searchable()
                ->noSearchResultsMessage('No se encontró el producto/servicio.')
                ->columnSpan('full'),
            Forms\Components\Textarea::make('observation')
                ->label('Observaciones')
                ->default('Sin observaciones')
                ->autosize()
                ->required()
        ];

        array_splice($components, 1, 0, $component);
        // array_merge($component,$components);
        // dd($components);
        return $form
            ->columns(1)
            ->schema($components);
    }
    public function table(Table $table): Table
    {
        $columns = [
            Tables\Columns\TextColumn::make('product.name')
                ->label('Producto/Servicio'),
            Tables\Columns\TextColumn::make('product.unit.acronym')
                ->label('Unidad'),
            Tables\Columns\TextColumn::make('quantity')
                ->label('Cantidad'),
            Tables\Columns\TextColumn::make('observation')
                ->label('Observaciones')
                ->limit(30)
                ->action(
                    Tables\Actions\Action::make('Observaciones')
                        ->modal()
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->modalContent(fn($record) => view('filament.table.view-observation', ['observation' => $record->observation]))
                )
        ];
        $column = [];
        if ($this->getOwnerRecord()->currency == 'USD') {
            $column = [
                MoneyColumn::make('unit_price')
                    ->currency('USD')
                    ->locale('en_US')
                    ->label('Precio unitario'),
                MoneyColumn::make('sub_total')
                    ->currency('USD')
                    ->locale('en_US')
                    ->label('Importe')
                    ->summarize(Sum::make()->label('Subtotal')->money('USD', divideBy: 100, locale: 'en_US'))
            ];
        }

        if ($this->getOwnerRecord()->currency == 'MXN') {
            $column = [
                MoneyColumn::make('unit_price')
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->label('Precio unitario'),
                MoneyColumn::make('sub_total')
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->label('Importe')
                    ->summarize(Sum::make()->label('Subtotal')->money('USD', divideBy: 100, locale: 'en_USD')),
            ];
        }
        $columns = array_merge($columns, $column);


        return $table
            ->recordTitleAttribute('product.name')
            ->columns($columns)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading(fn($record) => "Editar partida {$record->product->name}")
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
