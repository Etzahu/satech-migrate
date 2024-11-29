<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\Textarea::make('address')
                    ->label('Dirección fiscal')
                    ->validationAttribute('dirección fiscal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('acronym')
                    ->label('Acronimo')
                    ->validationAttribute('acronimo')
                    ->unique(Company::class, 'acronym')
                    ->maxLength(3)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Razón social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acronym')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección fiscal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
        ;
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
