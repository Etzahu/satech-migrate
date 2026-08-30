<?php

namespace App\Filament\Purchases\Pages;

use App\Models\PurchaseOrderSheetConfig;
use App\Models\User;
use App\Services\GoogleSheetsService;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfigureGoogleSheetsReport extends Page
{
    protected static ?string $navigationLabel = 'Configurar Reporte Google Sheets';

    protected static ?string $title = 'Configurar Reporte de Google Sheets';

    protected string $view = 'filament.purchases.pages.configure-google-sheets-report';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 13;

    public ?array $data = [];

    public ?PurchaseOrderSheetConfig $config = null;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('gerente_compras') ||
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('administrador_compras');
    }

    public function mount(): void
    {
        $this->config = PurchaseOrderSheetConfig::getOrCreateForUser(Auth::id());
        $this->form->fill($this->config->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Configuración de Reporte Automático')
                    ->description('Configura qué datos se exportarán automáticamente a Google Sheets cuando se creen o actualicen órdenes de compra.')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Activar exportación automática')
                            ->helperText('Si está activo, cada cambio en las órdenes actualizará tu hoja de Google Sheets')
                            ->default(true)
                            ->inline(false)
                            ->columnSpanFull(),

                        Forms\Components\CheckboxList::make('columns')
                            ->label('Datos de la orden a exportar')
                            ->bulkToggleable()
                            ->columns(4)
                            ->required()
                            ->options([
                                'fecha de creacion' => 'Fecha de creación',
                                'comprador' => 'Comprador',
                                'folio' => 'Folio',
                                'proveedor' => 'Proveedor',
                                'subtotal' => 'Subtotal',
                                'total' => 'Total',
                                'partidas' => 'Partidas',
                                'moneda' => 'Moneda',
                                'proyecto' => 'Proyecto',
                                'tipo de pago' => 'Tipo de pago',
                                'forma de pago' => 'Forma de pago',
                                'condiciones de pago' => 'Condiciones de pago',
                                'folio de cotización' => 'Folio de cotización',
                                'uso de CFDI' => 'Uso de CFDI',
                                'método de envío' => 'Método de envío',
                                'iva' => 'IVA',
                                'descuento por proveedor' => 'Descuento por proveedor',
                                'retención de IVA' => 'Retención de IVA',
                                'retención de ISR' => 'Retención de ISR',
                                'fecha de entrega inicial' => 'Fecha de entrega inicial',
                                'fecha de entrega final' => 'Fecha de entrega final',
                                'dirección de entrega' => 'Dirección de entrega',
                                'documentación de entrega' => 'Documentación de entrega',
                                'observaciones' => 'Observaciones',
                                'contacto de proveedor' => 'Contacto de proveedor',
                                'empresa' => 'Empresa',
                                'requisición' => 'Requisición',
                                'estatus' => 'Estatus',
                            ])
                            ->columnSpanFull(),
                    ]),

                Schemas\Components\Section::make('Rango de Fechas')
                    ->description('Define el período de órdenes que se incluirán en el reporte')
                    ->schema([
                        Forms\Components\Radio::make('date_range_type')
                            ->label('Tipo de rango')
                            ->options([
                                'days' => 'Últimos X días',
                                'custom' => 'Rango personalizado',
                            ])
                            ->default('days')
                            ->reactive()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('days_range')
                            ->label('Número de días')
                            ->helperText('Se exportarán las órdenes de los últimos X días')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(365)
                            ->default(30)
                            ->required()
                            ->visible(fn (Get $get) => $get('date_range_type') === 'days'),

                        Forms\Components\DatePicker::make('custom_start_date')
                            ->label('Fecha inicio del reporte')
                            ->helperText('El reporte incluirá órdenes desde esta fecha hasta hoy')
                            ->required(fn (Get $get) => $get('date_range_type') === 'custom')
                            ->visible(fn (Get $get) => $get('date_range_type') === 'custom')
                            ->maxDate(now()),
                    ]),

                Schemas\Components\Section::make('Filtros Adicionales (Opcional)')
                    ->description('Filtra las órdenes que se exportarán')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Select::make('buyers')
                            ->label('Compradores específicos')
                            ->helperText('Si no seleccionas ninguno, se incluirán todos')
                            ->multiple()
                            ->nullable()
                            ->options(function () {
                                return User::withRole('comprador')->pluck('name', 'id');
                            })
                            ->searchable(),

                        Forms\Components\CheckboxList::make('type_purchase')
                            ->label('Tipo de compra')
                            ->helperText('Si no seleccionas ninguno, se incluirán todos')
                            ->columns(2)
                            ->options([
                                'proveeduria' => 'Producto',
                                'servicio' => 'Servicio',
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Validar que al menos una columna esté seleccionada
            if (empty($data['columns'])) {
                Notification::make()
                    ->title('Error de validación')
                    ->danger()
                    ->body('Debes seleccionar al menos una columna para exportar')
                    ->send();

                return;
            }

            // Validar fecha personalizada si es necesario
            if ($data['date_range_type'] === 'custom') {
                if (empty($data['custom_start_date'])) {
                    Notification::make()
                        ->title('Error de validación')
                        ->danger()
                        ->body('Debes especificar la fecha de inicio para el rango personalizado')
                        ->send();

                    return;
                }
            }

            // Actualizar o crear configuración
            $this->config->update($data);

            // Actualizar el reporte inmediatamente con la nueva configuración
            $this->updateGoogleSheetsReport();

            Notification::make()
                ->title('Configuración guardada')
                ->success()
                ->body('Tu configuración se ha guardado y tu reporte de Google Sheets ha sido actualizado correctamente.')
                ->persistent()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al guardar')
                ->danger()
                ->body('Ocurrió un error: '.$e->getMessage())
                ->persistent()
                ->send();
        }
    }

    /**
     * Actualiza el reporte de Google Sheets con la configuración actual
     */
    protected function updateGoogleSheetsReport(): void
    {
        try {
            // Calcular rango de fechas según configuración
            if ($this->config->date_range_type === 'days') {
                $startDate = now()->subDays($this->config->days_range)->format('Y-m-d');
                $endDate = now()->format('Y-m-d');
            } else {
                // En rango personalizado, la fecha de inicio es la configurada y la fecha final es siempre hoy
                $startDate = $this->config->custom_start_date?->format('Y-m-d') ?? now()->subDays(30)->format('Y-m-d');
                $endDate = now()->format('Y-m-d');
            }

            // Preparar datos según configuración del usuario
            $formData = [
                'type_save' => 'sheets',
                'columns' => $this->config->columns ?? PurchaseOrderSheetConfig::defaultColumns(),
                'created_start' => $startDate,
                'created_end' => $endDate,
                'buyers' => $this->config->buyers ?? [],
                'type_purchase' => $this->config->type_purchase ?? [],
            ];

            $sheetsService = new GoogleSheetsService;
            $result = $sheetsService->processOrdersReport($formData);

            Log::info('Reporte de Google Sheets actualizado manualmente desde configuración', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'total_orders' => $result['total_orders'] ?? 0,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar reporte de Google Sheets desde configuración', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // No lanzar excepción para que no interrumpa el guardado de la configuración
            Notification::make()
                ->title('Advertencia')
                ->warning()
                ->body('La configuración se guardó pero hubo un problema al actualizar el reporte: '.$e->getMessage())
                ->send();
        }
    }

    public function getMaxContentWidth(): Width
    {
        return Width::SevenExtraLarge;
    }

    public function resetToDefaults(): void
    {
        $this->form->fill([
            'columns' => PurchaseOrderSheetConfig::defaultColumns(),
            'days_range' => 30,
            'date_range_type' => 'days',
            'is_active' => true,
            'buyers' => null,
            'type_purchase' => null,
            'custom_start_date' => null,
        ]);

        Notification::make()
            ->title('Valores restablecidos')
            ->info()
            ->body('Los valores por defecto se han restaurado. Recuerda guardar los cambios.')
            ->send();
    }
}
