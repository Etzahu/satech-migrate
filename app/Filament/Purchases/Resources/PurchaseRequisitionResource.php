<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Pages\PurchaseRequisition\ViewPdf;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;



class PurchaseRequisitionResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciones';
    protected static ?string $navigationLabel = 'Mis requisiciones';
    protected static ?string $slug = 'mis-requisiciones';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 1;


    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('solicitante_requisicion_compra');
    }
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'view_review_warehouse',
            'view_review',
            'view_approve',
            'view_approve_dg',
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->myRequisitions();
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::myRequisitionsDraft()->count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->columns([
                        'sm' => 2,
                        'xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\Textarea::make('motive')
                            ->label('Referencia')
                            ->maxLength(600)
                            ->required(),
                        Forms\Components\DatePicker::make('date_delivery')
                            ->label('Fecha deseable de entrega')
                            ->minDate(now())
                            ->default(now()->addDay(3))
                            ->required(),
                        Forms\Components\Textarea::make('delivery_address')
                            ->label('Dirección de entrega')
                            ->required()
                            ->maxLength(500),
                        Forms\Components\Select::make('project_id')
                            ->label('Proyecto')
                            ->relationship('project', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('company_id', session()->get('company_id'))->where('status', 1))
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "({$record->code}){$record->name}")
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                Forms\Components\Section::make('Flujo de aprobación')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('reviewer_id')
                            ->label('Revisa')
                            ->options(
                                PurchaseRequisitionApprovalChain::with(['reviewer'])
                                    ->where('requester_id', auth()->user()->id)->get()
                                    ->pluck('reviewer.name', 'reviewer.id')
                            )
                            ->required(),
                        Forms\Components\Select::make('approver_id')
                            ->label('Aprueba')
                            ->options(
                                PurchaseRequisitionApprovalChain::with(['approver'])
                                    ->where('requester_id', auth()->user()->id)->get()
                                    ->pluck('approver.name', 'approver.id')
                            )
                            ->required()
                    ]),
                Forms\Components\Section::make('Documentación adicional')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('technical_data_sheets')
                            ->label('Fichas técnicas')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('technical_data_sheets')
                            ->multiple(),
                        SpatieMediaLibraryFileUpload::make('supports')
                            ->label('Soportes')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('supports')
                            ->multiple(),
                        Forms\Components\Textarea::make('observation')
                            ->label('Observación adicionales')
                            ->maxLength(600)
                            ->required(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->visible(function (PurchaseRequisition $record) {
                            $states = [
                                'borrador',
                                'devuelto por revisor',
                                'devuelto por gerencia',
                                'devuelto por DG',
                            ];
                            return in_array($record->status, $states);
                        }),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn(PurchaseRequisition $record): string => PurchaseRequisitionResource::getUrl('view-pdf', ['record' => $record->id]))
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {

        return [
            'index' => Pages\ListPurchaseRequisitions::route('/'),
            'create' => Pages\CreatePurchaseRequisition::route('/create'),
            'view' => Pages\ViewPurchaseRequisition::route('/{record}'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
            'view-pdf'=> Pages\ViewPdf::route('/pdf/{record}'),
        ];
    }
}
