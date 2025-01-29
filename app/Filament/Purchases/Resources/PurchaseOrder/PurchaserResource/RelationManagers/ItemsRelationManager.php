<?php

// namespace App\Filament\Purchases\Resources\PurchaserResource\RelationManagers;
namespace App\Filament\Purchases\Resources\PurchaseResource\PurchaserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Livewire\Attributes\On;

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
        if ($this->getOwnerRecord()->currency == 'USD') {
            return $form
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label('Cantidad')
                        ->required()
                        ->minValue(0)
                        ->integer(),
                    MoneyInput::make('unit_price')
                        ->label('Precio unitario')
                        ->currency('USD')
                        ->locale('en_US')
                        ->required()
                        ->minValue(0)
                        ->numeric(),
                    Forms\Components\Select::make('product_id')
                        ->label('Producto/Servicio')
                        ->options(Product::where('status', 'aprobado')->where('company_id', session()->get('company_id'))->pluck('name', 'id'))
                        ->searchPrompt('Busca los productos o servicios por su descripción')
                        ->searchable()
                        ->noSearchResultsMessage('No se encontró el producto/servicio.')
                        ->columnSpan('full'),
                    Forms\Components\Textarea::make('observation')
                        ->label('Observaciones')
                        ->default('Sin observaciones')
                        ->required()
                ]);
        } else {
            return $form
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label('Cantidad')
                        ->required()
                        ->minValue(0)
                        ->integer(),
                    MoneyInput::make('unit_price')
                        ->label('Precio unitario')
                        ->currency('MXN')
                        ->locale('es_MX')
                        ->required()
                        ->minValue(0)
                        ->numeric(),
                    Forms\Components\Select::make('product_id')
                        ->label('Producto/Servicio')
                        ->options(Product::all()->pluck('name', 'id'))
                        ->searchPrompt('Busca los productos o servicios por su descripción')
                        ->searchable()
                        ->noSearchResultsMessage('No se encontró el producto/servicio.')
                        ->columnSpan('full'),
                    Forms\Components\Textarea::make('observation')
                        ->label('Observaciones')
                ]);
        }
    }
    public function table(Table $table): Table
    {
        if ($this->getOwnerRecord()->currency == 'USD') {
            return $table
                ->recordTitleAttribute('product.name')
                ->columns([
                    Tables\Columns\TextColumn::make('product.name')
                        ->label('Producto/Servicio'),
                    Tables\Columns\TextColumn::make('product.unit.acronym')
                        ->label('Unidad'),
                    Tables\Columns\TextColumn::make('quantity')
                        ->label('Cantidad'),
                    MoneyColumn::make('unit_price')
                        ->currency('USD')
                        ->locale('en_US')
                        ->label('Precio unitario'),
                    MoneyColumn::make('unit_price')
                        ->currency('USD')
                        ->locale('en_US')
                        ->label('Precio unitario'),
                    MoneyColumn::make('sub_total')
                        ->currency('USD')
                        ->locale('en_US')
                        ->label('Importe')
                        ->summarize(Sum::make()->label('Subtotal')->money('USD', divideBy: 100, locale: 'en_US')),
                ])
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
                        })->mutateRecordDataUsing(function (array $data): array {
                            // dd($data);
                            return $data;
                        }),
                    Tables\Actions\DeleteAction::make(),
                ]);
        } else {
            return $table
                ->recordTitleAttribute('product.name')
                ->columns([
                    Tables\Columns\TextColumn::make('product.name')
                        ->label('Producto/Servicio'),
                    Tables\Columns\TextColumn::make('product.unit.acronym')
                        ->label('Unidad'),
                    Tables\Columns\TextColumn::make('quantity')
                        ->label('Cantidad'),
                    MoneyColumn::make('unit_price')
                        ->currency('MXN')
                        ->locale('es_MX')
                        ->label('Precio unitario'),
                    MoneyColumn::make('unit_price')
                        ->currency('MXN')
                        ->locale('es_MX')
                        ->label('Precio unitario'),
                    MoneyColumn::make('sub_total')
                        ->currency('MXN')
                        ->locale('es_MX')
                        ->label('Importe')
                        ->summarize(Sum::make()->label('Subtotal')->money('USD', divideBy: 100, locale: 'en_USD')),
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

                ])
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
                        })->mutateRecordDataUsing(function (array $data): array {
                            // dd($data);
                            return $data;
                        }),
                    Tables\Actions\DeleteAction::make(),
                ]);
        }
    }
}
