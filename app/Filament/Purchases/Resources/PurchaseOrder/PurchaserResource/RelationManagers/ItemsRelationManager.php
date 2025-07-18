<?php

// namespace App\Filament\Purchases\Resources\PurchaserResource\RelationManagers;
namespace App\Filament\Purchases\Resources\PurchaseResource\PurchaserResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Brick\Money\Money;
use App\Models\Product;
use Filament\Forms\Form;
use Brick\Math\BigDecimal;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Illuminate\Support\HtmlString;
use App\Forms\Components\MoneyInput;
use Brick\Money\Context\CustomContext;
use Filament\Resources\RelationManagers\RelationManager;


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
        // $component = [];
        // if ($this->getOwnerRecord()->currency == 'MXN') {
        //     $component = [
        //         MoneyInput::make('unit_price')
        //             ->label('Precio unitario')
        //             ->required()
        //             ->decimals(4)
        //             ->minValue(0)
        //             // ->afterStateHydrated(function ($component,  $state) {
        //             //     if (is_null($state)) {
        //             //         return null;
        //             //     }
        //             //     if (! is_numeric($state)) {
        //             //         return $state;
        //             //     }
        //             //     if ($state == 0) {
        //             //         return 0;
        //             //     }
        //             //     $component->state($state / 100);
        //             // })
        //             ->numeric()
        //     ];
        // }
        // if ($this->getOwnerRecord()->currency == 'USD') {
        //     $component =  [MoneyInput::make('unit_price')
        //         ->label('Precio unitario')
        //         ->required()
        //         ->decimals(4)
        //         ->minValue(0)
        //         // ->afterStateHydrated(function ($component,  $state) {
        //         //     if (is_null($state)) {
        //         //         return null;
        //         //     }
        //         //     if (! is_numeric($state)) {
        //         //         return $state;
        //         //     }
        //         //     if ($state == 0) {
        //         //         return 0;
        //         //     }
        //         //     $component->state($state / 100);
        //         // })
        //         ->numeric()];
        // }

        // $components =  [
        //     Forms\Components\TextInput::make('quantity')
        //         ->label('Cantidad')
        //         ->required()
        //         ->minValue(0)
        //         ->integer(),
        //     Forms\Components\Select::make('product_id')
        //         ->label('Producto/Servicio')
        //         ->options(function () {
        //             $type = $this->getOwnerRecord()->requisition->category;
        //             if (session()->get('company_id') == 1) { //ID 1:GPT IM
        //                 return Product::where('status', 'aprobado')
        //                     ->where('company_id', session()->get('company_id'))
        //                     ->pluck('name', 'id');
        //             }

        //             if (filled($type)) {
        //                 return Product::where('status', 'aprobado')
        //                     ->where('company_id', session()->get('company_id'))
        //                     ->where('type_purchase', $type)
        //                     ->pluck('name', 'id');
        //             } else {
        //                 return Product::where('status', 'aprobado')
        //                     ->where('company_id', session()->get('company_id'))
        //                     ->pluck('name', 'id');
        //             }
        //         })
        //         ->searchPrompt('Busca los productos o servicios por su descripción')
        //         ->searchable()
        //         ->noSearchResultsMessage('No se encontró el producto/servicio.')
        //         ->columnSpan('full'),
        //     Forms\Components\Textarea::make('observation')
        //         ->label('Observaciones')
        //         ->default('Sin observaciones')
        //         ->autosize()
        //         ->required()
        // ];

        // array_splice($components, 1, 0, $component);
        // array_merge($component,$components);
        // dd($components);
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
                    ->helperText(new HtmlString("<p class='p-1 text-white bg-red-500 rounded-md'>La cantidad debe ser un número sin espacios ni comillas y con exactamente 4 decimales (ej: 0.0000).</p>"))
                    ->required()
                    ->rules([
                        fn(): Closure => function (string $attribute, $value, Closure $fail) {
                            if (preg_match('/^\d+\.\d{4}$/', $value)) {
                                return true;
                            } else {
                                $fail('El :attribute no es válido.');
                            }
                        },
                    ]),
                // Forms\Components\TextInput::make('unit_price')
                //     ->label('Precio unitario')
                //     ->required()
                //     ->numeric()
                //     ->inputMode('decimal')
                //     ->minValue(0),
                Forms\Components\Select::make('product_id')
                    ->label('Producto/Servicio')
                    ->options(function () {
                        return Product::where('status', 'aprobado')
                            ->where('company_id', session()->get('company_id'))
                            ->pluck('name', 'id');

                        // $type = $this->getOwnerRecord()->requisition->category;
                        // if (session()->get('company_id') == 1) { //ID 1:GPT IM
                        //     return Product::where('status', 'aprobado')
                        //         ->where('company_id', session()->get('company_id'))
                        //         ->pluck('name', 'id');
                        // }

                        // if (filled($type)) {
                        //     return Product::where('status', 'aprobado')
                        //         ->where('company_id', session()->get('company_id'))
                        //         ->where('type_purchase', $type)
                        //         ->pluck('name', 'id');
                        // } else {
                        //     return Product::where('status', 'aprobado')
                        //         ->where('company_id', session()->get('company_id'))
                        //         ->pluck('name', 'id');
                        // }
                    })
                    ->searchPrompt('Busca los productos o servicios por su descripción')
                    ->searchable()
                    ->noSearchResultsMessage('No se encontró el producto/servicio.')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('observation')
                    ->label('Observaciones')
                    ->default('Sin observaciones')
                    ->autosize()
            ]);
    }
    public function table(Table $table): Table
    {
        // $columns = [
        //     Tables\Columns\TextColumn::make('product.name')
        //         ->label('Producto/Servicio'),
        //     Tables\Columns\TextColumn::make('product.unit.acronym')
        //         ->label('Unidad'),
        //     Tables\Columns\TextColumn::make('quantity')
        //         ->label('Cantidad'),
        //     Tables\Columns\TextColumn::make('unit_price')
        //         ->label('Precio unitario'),
        //     Tables\Columns\TextColumn::make('sub_total')
        //         ->label('Importe')
        //         ->summarize(Sum::make()->label('Subtotal')->money('CLF', divideBy: 100, locale: 'en_US')),
        //     Tables\Columns\TextColumn::make('observation')
        //         ->label('Observaciones')
        //         ->limit(30)
        //         ->action(
        //             Tables\Actions\Action::make('Observaciones')
        //                 ->modal()
        //                 ->modalSubmitAction(false)
        //                 ->modalCancelAction(false)
        //                 ->modalContent(fn($record) => view('filament.table.view-observation', ['observation' => $record->observation]))
        //         )
        // ];
        // $column = [];
        // if ($this->getOwnerRecord()->currency == 'USD') {
        //     $column = [
        //         MoneyColumn::make('unit_price')
        //             ->label('Precio unitario'),
        //         MoneyColumn::make('sub_total')
        //             ->label('Importe')
        //             ->summarize(Sum::make()->label('Subtotal')->money('CLF', divideBy: 100, locale: 'en_US'))
        //     ];

        // }

        // if ($this->getOwnerRecord()->currency == 'MXN') {
        //     $column = [
        //         MoneyColumn::make('unit_price')
        //             ->label('Precio unitario'),
        //             MoneyColumn::make('sub_total')
        //             ->label('Importe')
        //             ->summarize(Sum::make()->label('Subtotal')->money('CLF', divideBy: 100, locale: 'en_USD')),
        //         ];
        //         // dd($column);
        //     }
        // $columns = array_merge($columns, $column);

        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto/Servicio'),
                Tables\Columns\TextColumn::make('product.unit.acronym')
                    ->label('Unidad'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad'),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Precio unitario')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return 0;
                        }
                        $state = BigDecimal::of($state)->dividedBy(10000, 4);
                        return (string) $state;
                    }),
                Tables\Columns\TextColumn::make('sub_total')
                    ->label('Importe')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return 0;
                        }
                        $state = BigDecimal::of($state)->dividedBy(10000, 4);
                        return (string) $state;
                    }),
                // ->summarize(Sum::make()->label('Subtotal')->money('CLF', divideBy: 100, locale: 'en_US')),
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
                        // dd($data);
                        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
