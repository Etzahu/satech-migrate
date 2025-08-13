<?php

namespace App\Filament\Purchases\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProjectPurchase;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Actions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use App\Filament\Purchases\Resources\ProjectPurchaseResource\RelationManagers;

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

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('gerente_compras') || auth()->user()->hasRole('administrador_compras') || auth()->user()->hasRole('super_admin');
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', session()->get('company_id'));
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pendiente')
            ->where('company_id', session()->get('company_id'))->count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Código')
                            ->helperText('Debe empezar con ' . (session()->get('company_id') == 1 ? 'NP,' . ' ejemplo NP-001/25' : 'DN,' . ' ejemplo DN-001/25'))
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
                            ->label('Nombre completo del proyecto')
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
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
                Tables\Actions\BulkAction::make('aceptar')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        try {
                            $records->each(function ($item) {
                                $item->status()->transitionTo('activo');
                            });
                            Notification::make()
                                ->title('Respuesta enviada')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessages());
                            Notification::make()
                                ->title('Ocurrió un error.')
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(Model $record): bool => $record->status == 'pendiente',
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectPurchases::route('/'),
            'create' => Pages\CreateProjectPurchase::route('/create'),
            'view' => Pages\ViewProjectPurchase::route('/{record}'),
            'edit' => Pages\EditProjectPurchase::route('/{record}/edit'),
        ];
    }
}
