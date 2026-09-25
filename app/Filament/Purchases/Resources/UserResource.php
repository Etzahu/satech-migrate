<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\UserResource\Pages;
use App\Models\Management;
use App\Models\User;
use Closure;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use STS\FilamentImpersonate\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $slug = 'usuarios';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $form): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Schemas\Components\Tabs::make('Tabs')
                    ->tabs([
                        Schemas\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->label('ID del colaborador')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Ya existe un usuario con este ID de colaborador.',
                                    ])
                                    ->disabledOn('edit'),
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    // El nombre tampoco puede repetirse. Va como regla propia
                                    // y no como unique() para poder distinguir el caso en que
                                    // además coincide el ID: ahí no es un homónimo, es el
                                    // mismo colaborador dado de alta dos veces.
                                    ->rules([
                                        fn (Get $get, ?User $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                                            $twins = User::query()
                                                ->where('name', $value)
                                                ->when($record, fn (Builder $query) => $query->whereKeyNot($record->getKey()))
                                                ->pluck('id');

                                            if ($twins->isEmpty()) {
                                                return;
                                            }

                                            $fail($twins->contains((int) $get('id'))
                                                ? 'Ya existe un usuario con este mismo ID de colaborador y nombre.'
                                                : 'Ya existe un usuario con este nombre.');
                                        },
                                    ]),
                                Forms\Components\TextInput::make('email')
                                    ->label('Correo')
                                    ->required()
                                    ->email('gptservices')
                                    ->endsWith(['@gptservices.com'])
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Celular')
                                    ->tel()
                                    ->maxLength(20),
                                Forms\Components\Select::make('management_id')
                                    ->label('Gerencia')
                                    ->options(Management::pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('puesto')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Toggle::make('active')
                                    ->default(1)
                                    ->required(),

                            ]),
                        Schemas\Components\Tabs\Tab::make('Roles')
                            ->schema([
                                // Forms\Components\Select::make('roles')
                                //     ->relationship('roles', 'name')
                                //     ->multiple()
                                //     ->preload()
                                //     ->searchable(),
                                Forms\Components\CheckboxList::make('roles')
                                    ->relationship('roles', 'name')
                                    ->searchable(),
                            ]),
                    ]),
            ]);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist
            ->columns(1)
            ->schema([
                Schemas\Components\Section::make('Datos del colaborador')
                    ->icon('heroicon-o-identification')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID del colaborador'),
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nombre')
                            ->weight(FontWeight::Bold),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Correo')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Celular')
                            ->placeholder('Sin registrar'),
                        Infolists\Components\TextEntry::make('management.name')
                            ->label('Gerencia')
                            // Sin gerencia el usuario no puede levantar requisiciones:
                            // el folio se arma con sus siglas.
                            ->placeholder('Sin gerencia asignada')
                            ->color(fn ($record) => $record->management ? null : 'danger'),
                        Infolists\Components\TextEntry::make('puesto')
                            ->label('Puesto')
                            ->placeholder('Sin registrar'),
                        Infolists\Components\IconEntry::make('active')
                            ->label('Activo')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Alta')
                            ->dateTime('d-m-Y'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Última actualización')
                            ->dateTime('d-m-Y'),
                    ]),

                Schemas\Components\Section::make('Roles')
                    ->icon('heroicon-o-shield-check')
                    ->description('Determinan qué módulos ve el usuario y qué guías se le proponen en la invitación.')
                    ->schema([
                        Infolists\Components\TextEntry::make('roles.name')
                            ->label('')
                            ->badge()
                            ->placeholder('Sin roles asignados'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID del colaborador')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('management.name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Impersonate::make()
                    ->visible(auth()->user()->hasRole('super_admin')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
