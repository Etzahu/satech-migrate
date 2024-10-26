<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;
use App\Filament\Purchases\Resources\ProjectPurchaseResource\RelationManagers;
use App\Models\ProjectPurchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;

class ProjectPurchaseResource extends Resource
{
    protected static ?string $model = ProjectPurchase::class;
    protected static ?string $modelLabel = 'Proyecto';
    protected static ?string $pluralModelLabel = 'Proyectos';
    protected static ?string $navigationLabel = 'Proyectos';
    protected static ?string $slug = 'proyectos';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', session()->get('company_id'));
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Folio')
                            ->helperText('Debe empezar con ' . (session()->get('company_id') == 1 ? 'NP' : 'DN'))
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->rules([
                                fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                    if (session()->get('company_id') == 1) {
                                        if (!str($value)->startsWith('NP-')) {
                                            $fail('El :attribute debe comenzar con NP-');
                                        }
                                    }
                                    if (session()->get('company_id') == 2) {
                                        if (!str($value)->startsWith('DN-')) {
                                            $fail('El :attribute debe comenzar con DN-');
                                        }
                                    }
                                },
                            ])
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->label('Activo')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Folio'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')
                    ->sortable(),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectPurchases::route('/'),
            'create' => Pages\CreateProjectPurchase::route('/create'),
            'edit' => Pages\EditProjectPurchase::route('/{record}/edit'),
        ];
    }
}
