<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\CompanyResource\Pages;
use App\Filament\Purchases\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $pluralModelLabel = 'Empresas';
    protected static ?string $navigationLabel = 'Empresas';
    protected static ?string $slug = 'empresas';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('short_name')
                            ->required()
                            ->label('Nombre corto')
                            ->validationAttribute('Nombre corto')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('acronym')
                            ->label('Acronimo')
                            ->validationAttribute('acronimo')
                            ->unique(Company::class, 'acronym', ignoreRecord: true)
                            ->maxLength(3)
                            ->required(),
                    ]),
                Forms\Components\Section::make('Datos para facturación')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Razón social')
                            ->validationAttribute('Razón social')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('rfc')
                            ->label('RFC')
                            ->validationAttribute('RFC')
                            ->required()
                            ->maxLength(18),
                        Forms\Components\TextInput::make('street')
                            ->label('Calle')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('number')
                            ->label('Número')
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
                            ->label('Código Postal')
                            ->required()
                            ->maxLength(10),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acronym')
                    ->label('Abreviatura')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
