<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;
use App\Filament\Purchases\Resources\PurchaseProviderResource\RelationManagers;
use App\Models\PurchaseProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseProviderResource extends Resource
{
    protected static ?string $model = PurchaseProvider::class;
    protected static ?string $modelLabel = 'Proveedor';
    protected static ?string $pluralModelLabel = 'Proveedores';
    protected static ?string $navigationLabel = 'Proveedores';
    protected static ?string $slug = 'proveedores';
    // protected static ?string $navigationGroup = '';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('rfc')
                            ->label('RFC')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Razón social')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('street')
                            ->label('Calle')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('number')
                            ->label('Número #')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('neighborhood')
                            ->label('Colonia')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('municipality')
                            ->label('Municipio')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('state')
                            ->label('Estado')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('País')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cp')
                            ->label('Código postal')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('web_company')
                            ->label('Sitio web  de la empresa')
                            ->nullable()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Razón social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('UserRequest.name')
                    ->label('Cargo información')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'revisión' => 'warning',
                        'rechazado' => 'danger',
                        'aprobado' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
           ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseProviders::route('/'),
            'create' => Pages\CreatePurchaseProvider::route('/create'),
            'view' => Pages\ViewPurchaseProvider::route('/{record}'),
            'edit' => Pages\EditPurchaseProvider::route('/{record}/edit'),
        ];
    }
}
