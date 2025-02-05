<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Support\MediaStream;
use App\Models\PurchaseRequisitionApprovalChain;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;
use Filament\Forms\Components\Component;

class RequesterResource extends Resource implements HasShieldPermissions
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
        return auth()->user()->hasRole('solicita_requisicion_compra');
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
            'view_authorize',
            'view_assing'
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->myRequisitionsDraft();
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::myRequisitionsDraft()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Información general')
                            ->schema([
                                Forms\Components\Textarea::make('motive')
                                    ->label('Referencia')
                                    ->maxLength(600)
                                    ->required(),
                                Forms\Components\Select::make('priority')
                                    ->label('Prioridad')
                                    ->options([
                                        'baja' => 'Baja',
                                        'media' => 'Media',
                                        'alta' => 'Alta'
                                    ])
                                    ->default('baja')
                                    ->required(),
                                Forms\Components\Select::make('type')
                                    ->label('Tipo de requisición')
                                    ->options([
                                        'compra' => 'Compra',
                                        'cotización' => 'Cotización'
                                    ])
                                    ->required(),
                                Forms\Components\DatePicker::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->minDate(now()->subDay(1))
                                    ->default(now()->addDay(3))
                                    ->required(),
                                Forms\Components\Textarea::make('delivery_address')
                                    ->label('Dirección de entrega')
                                    ->required()
                                    ->maxLength(500),
                                Forms\Components\Select::make('project_id')
                                    ->label('Proyecto')
                                    ->relationship('project', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('company_id', session()->get('company_id'))->where('status', 'activo'))
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "({$record->code}){$record->name}")
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Toggle::make("confidential")
                                    ->label("Confidencial")
                                    ->visible(false)
                                    ->default(false)
                                    ->live()
                            ]),
                        Forms\Components\Tabs\Tab::make('Flujo de aprobación')
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
                                    ->requiredIf('confidential', false),
                                Forms\Components\Select::make('approver_id')
                                    ->label('Aprueba')
                                    ->options(
                                        PurchaseRequisitionApprovalChain::with(['approver'])
                                            ->where('requester_id', auth()->user()->id)->get()
                                            ->pluck('approver.name', 'approver.id')
                                    )
                                    ->requiredIf('confidential', false)
                            ]),
                        Forms\Components\Tabs\Tab::make('Fichas técnicas')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('technical_data_sheets')
                                    ->label('Fichas técnica')
                                    ->multiple()
                                    ->hint('Puedes adjuntar más de un documento.')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('technical_data_sheets'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Soportes')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('supports')
                                    ->label('Soportes')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->multiple()
                                    ->hintColor('danger')
                                    ->collection('supports'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Observación')
                            ->schema([
                                Forms\Components\Textarea::make('observation')
                                    ->label('Observación adicionales')
                                    ->maxLength(2000)
                                    ->default('Sin observaciones')
                                    ->required(),
                            ])
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist, $options = []): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Infolists\Components\Tabs::make('Tabs')
                    ->tabs([
                        Infolists\Components\Tabs\Tab::make('Información general')
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Estatus')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('type')
                                    ->label('Tipo de requisición')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('priority')
                                    ->label('Prioridad')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('approvalChain.requester.name')
                                    ->label('Solicitante'),
                                Infolists\Components\TextEntry::make('motive')
                                    ->label('Referencia'),
                                Infolists\Components\TextEntry::make('folio')
                                    ->label('Folio'),
                                Infolists\Components\TextEntry::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->date(),
                                Infolists\Components\TextEntry::make('project.name')
                                    ->label('Proyecto'),
                                Infolists\Components\TextEntry::make('delivery_address')
                                    ->label('Dirección de entrega'),
                                Infolists\Components\IconEntry::make('confidential')
                                    ->label('Confidencial')
                                    ->visible(false)
                                    ->boolean(),
                            ])
                            ->columns(3),
                        Infolists\Components\Tabs\Tab::make('Partidas')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('items')
                                    ->label('')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('product.code')
                                            ->label('Código'),
                                        Infolists\Components\TextEntry::make('product.name')
                                            ->label('Producto'),
                                        Infolists\Components\TextEntry::make('quantity_warehouse')
                                            ->label('Cantidad en almacén'),
                                        Infolists\Components\TextEntry::make('quantity_purchase')
                                            ->label('Cantidad para comprar'),
                                        Infolists\Components\TextEntry::make('observation')
                                            ->label('Observación')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(5)
                            ]),
                        Infolists\Components\Tabs\Tab::make('Flujo de aprobación')
                            ->schema([
                                Infolists\Components\TextEntry::make('approvalChain.requester.name')
                                    ->label('Solicitante'),
                                Infolists\Components\TextEntry::make('approvalChain.reviewer.name')
                                    ->label('Revisor'),
                                Infolists\Components\TextEntry::make('approvalChain.approver.name')
                                    ->label('Aprobador'),
                                Infolists\Components\TextEntry::make('approvalChain.authorizer.name')
                                    ->label('Autoriza'),
                            ])
                            ->columns(4),
                        Infolists\Components\Tabs\Tab::make('Fichas técnicas')
                            ->visible(fn($record) => $record->getMedia('technical_data_sheets')->count() > 0)
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        $record->media = $record->getMedia('technical_data_sheets');
                                        return $record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('Descargar fichas')
                                        ->action(function ($record) {
                                            $downloads = $record->getMedia('technical_data_sheets');
                                            return MediaStream::create($record->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                        Infolists\Components\Tabs\Tab::make('Soportes')
                            ->visible(fn($record) => $record->getMedia('supports')->count() > 0)
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        $media = Media::where('model_id', $record->id)
                                            ->where('collection_name', 'supports')
                                            ->get();
                                        $record->media = $media;
                                        return $record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('Descargar soportes')
                                        ->action(function ($record) {
                                            // $downloads = $record->getMedia('supports');
                                            $downloads = Media::where('model_id', $record->id)
                                                ->where('collection_name', 'supports')
                                                ->get();
                                            return MediaStream::create($record->folio . '-soportes.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                        Infolists\Components\Tabs\Tab::make('Observaciones')
                            ->schema([
                                Infolists\Components\TextEntry::make('observation')
                                    ->label('Observaciones'),
                            ]),
                        Infolists\Components\Tabs\Tab::make('Comprador asignado')
                            ->visible(fn($record) => filled($record->purchaser))
                            ->schema([
                                Infolists\Components\TextEntry::make('purchaser.name')
                                    ->label('Nombre'),
                            ]),
                        Infolists\Components\Tabs\Tab::make('Ordenes')
                            ->visible(fn($record) => filled($record->orders))
                            ->schema([
                                \Njxqlus\Filament\Components\Infolists\RelationManager::make()->manager(RelationManagers\OrdersRelationManager::class)->lazy(false)
                            ]),
                        Infolists\Components\Tabs\Tab::make('Historial')
                            ->schema([
                                Infolists\Components\ViewEntry::make('status')
                                    ->view('filament.infolists.entries.history'),
                            ]),
                    ]),
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
                                'devuelto por almacén',
                                'devuelto por revisor',
                                'devuelto por gerencia',
                                'devuelto por DG',
                                'devuelto por comprador'
                            ];
                            return in_array($record->status, $states);
                        }),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn($record) => (string)route('requisition.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
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
        ];
    }
}
