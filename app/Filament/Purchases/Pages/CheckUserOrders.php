<?php

namespace App\Filament\Purchases\Pages;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class CheckUserOrders extends Page implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected string $view = 'filament.purchases.pages.check-user-orders';

    protected static ?string $navigationLabel = 'Verificar órdenes';

    protected static ?string $title = 'Verificar órdenes de Compra Bloqueadas';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static ?int $navigationSort = 100;

    public ?int $selectedUserId = null;

    public ?array $data = [];

    public array $userStats = [
        'chains_as_approver' => 0,
        'chains_as_authorizer' => 0,
        'pending_orders_to_approve' => 0,
        'pending_orders_to_authorize' => 0,
    ];

    public Collection $ordersToApprove;

    public Collection $ordersToAuthorize;

    public function mount(): void
    {
        $this->form->fill();
        $this->ordersToApprove = collect();
        $this->ordersToAuthorize = collect();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('selectedUserId')
                    ->label('Usuario')
                    ->placeholder('Selecciona un usuario...')
                    ->options(User::query()
                        ->orderBy('name')
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->selectedUserId = $state;
                        $this->analyzeUser();
                    })
                    ->required(),
            ])
            ->statePath('data');
    }

    public function analyzeUser(): void
    {
        if (! $this->selectedUserId) {
            $this->resetStats();

            return;
        }

        $user = User::find($this->selectedUserId);

        if (! $user) {
            $this->resetStats();

            return;
        }

        $companyId = session()->get('company_id');

        // Buscar cadenas donde el usuario participa como aprobador o autorizador
        $chainsAsApprover = PurchaseRequisitionApprovalChain::where('approver_id', $this->selectedUserId)->get();
        $chainsAsAuthorizer = PurchaseRequisitionApprovalChain::where('authorizer_id', $this->selectedUserId)->get();

        // Obtener órdenes de compra pendientes que usan las cadenas del usuario
        $this->ordersToApprove = PurchaseOrder::whereHas('requisition.approvalChain', function ($query) use ($chainsAsApprover) {
            $query->whereIn('id', $chainsAsApprover->pluck('id'));
        })
            ->where('status', 'aprobado por gerente de compras')
            ->where('company_id', $companyId)
            ->with(['requisition.approvalChain', 'company', 'purchaser', 'provider'])
            ->get();

        $this->ordersToAuthorize = PurchaseOrder::whereHas('requisition.approvalChain', function ($query) use ($chainsAsAuthorizer) {
            $query->whereIn('id', $chainsAsAuthorizer->pluck('id'));
        })
            ->where('status', 'aprobado por gerente solicitante')
            ->where('company_id', $companyId)
            ->with(['requisition.approvalChain', 'company', 'purchaser', 'provider'])
            ->get();

        // Actualizar estadísticas
        $this->userStats = [
            'chains_as_approver' => $chainsAsApprover->count(),
            'chains_as_authorizer' => $chainsAsAuthorizer->count(),
            'pending_orders_to_approve' => $this->ordersToApprove->count(),
            'pending_orders_to_authorize' => $this->ordersToAuthorize->count(),
        ];
    }

    protected function resetStats(): void
    {
        $this->userStats = [
            'chains_as_approver' => 0,
            'chains_as_authorizer' => 0,
            'pending_orders_to_approve' => 0,
            'pending_orders_to_authorize' => 0,
        ];
        $this->ordersToApprove = collect();
        $this->ordersToAuthorize = collect();
    }

    public function getTotalPendingOrders(): int
    {
        return $this->userStats['pending_orders_to_approve']
            + $this->userStats['pending_orders_to_authorize'];
    }

    public function getTotalChains(): int
    {
        return $this->userStats['chains_as_approver']
            + $this->userStats['chains_as_authorizer'];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyRole(['super_admin', 'gerente_compras', 'administrador_compras']);
    }

    /**
     * Acción para cambiar la cadena de la requisición relacionada con la orden
     */
    public function reassignOrderRequisitionChainAction(): Action
    {
        return Action::make('reassignOrderRequisitionChain')
            ->label('Cambiar Cadena')
            ->icon('heroicon-o-arrow-path-rounded-square')
            ->color('warning')
            ->schema(function (Action $action) {
                $orderId = $action->getArguments()['order'];
                $order = PurchaseOrder::find($orderId);

                if (! $order || ! $order->requisition) {
                    return [];
                }

                $requesterId = $order->requisition->approvalChain->requester_id;
                $currentChainId = $order->requisition->approval_chain_id;

                // Buscar otras cadenas del mismo solicitante
                $availableChains = PurchaseRequisitionApprovalChain::where('requester_id', $requesterId)
                    ->where('id', '!=', $currentChainId)
                    ->get()
                    ->mapWithKeys(function ($chain) {
                        return [
                            $chain->id => "Cadena #{$chain->id} - Aprueba: {$chain->approver->name}, Autoriza: {$chain->authorizer->name}",
                        ];
                    })
                    ->toArray();

                $fields = [];

                if (count($availableChains) > 0) {
                    $fields[] = Forms\Components\Select::make('new_chain_id')
                        ->label('Seleccionar nueva cadena')
                        ->options($availableChains)
                        ->required()
                        ->helperText('Seleccione la cadena que se asignará a la requisición');

                    $fields[] = Forms\Components\Placeholder::make('current_info')
                        ->label('Cadena Actual')
                        ->content("Aprueba: {$order->requisition->approvalChain->approver->name} | Autoriza: {$order->requisition->approvalChain->authorizer?->name}");

                    $fields[] = Forms\Components\Placeholder::make('info')
                        ->content('💡 Al cambiar la cadena, la orden volverá al inicio del proceso de aprobación.');
                } else {
                    $fields[] = Forms\Components\Placeholder::make('warning')
                        ->content('⚠️ No hay otras cadenas disponibles para este solicitante. Use la acción "Crear Nueva Cadena" en su lugar.');
                }

                return $fields;
            })
            ->action(function (array $data, Action $action) {
                $orderId = $action->getArguments()['order'];
                $order = PurchaseOrder::find($orderId);

                if ($order && isset($data['new_chain_id'])) {
                    $requisition = $order->requisition;
                    $oldChainId = $requisition->approval_chain_id;

                    // Cambiar la cadena de la requisición
                    $requisition->approval_chain_id = $data['new_chain_id'];
                    $requisition->save();

                    $oldChain = PurchaseRequisitionApprovalChain::find($oldChainId);
                    $newChain = PurchaseRequisitionApprovalChain::find($data['new_chain_id']);

                    // Transicionar al nuevo estado 'cadena reasignada' con metadata
                    $order->status()->transitionTo('cadena reasignada', [
                        'comments' => "Cadena de aprobación cambiada. Anterior: Aprueba {$oldChain?->approver->name}, Autoriza {$oldChain?->authorizer->name}. Nueva: Aprueba {$newChain?->approver->name}, Autoriza {$newChain?->authorizer->name}. Realizado por ".auth()->user()->name,
                        'old_chain_id' => $oldChainId,
                        'new_chain_id' => $data['new_chain_id'],
                        'old_approver_id' => $oldChain?->approver_id,
                        'old_authorizer_id' => $oldChain?->authorizer_id,
                        'new_approver_id' => $newChain?->approver_id,
                        'new_authorizer_id' => $newChain?->authorizer_id,
                        'reassigned_by' => auth()->user()->id,
                        'reassigned_at' => now(),
                    ]);

                    // Transicionar inmediatamente al estado inicial del proceso
                    $order->status()->transitionTo('revisión gerente de compras');

                    Notification::make()
                        ->title('Cadena reasignada')
                        ->body("La orden {$order->folio} ha cambiado de cadena y se ha reiniciado el proceso")
                        ->success()
                        ->send();

                    $this->analyzeUser();
                }
            })
            ->modalHeading('Cambiar Cadena de Aprobación')
            ->modalDescription('Seleccione una nueva cadena de aprobación para la requisición')
            ->modalSubmitActionLabel('Cambiar y Resetear')
            ->modalWidth('2xl');
    }

    /**
     * Acción para crear nueva cadena y asignarla a la requisición actual
     */
    public function createChainForOrderAction(): Action
    {
        return Action::make('createChainForOrder')
            ->label('Crear Nueva Cadena')
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->schema(function (Action $action) {
                $orderId = $action->getArguments()['order'];
                $order = PurchaseOrder::find($orderId);

                if (! $order || ! $order->requisition) {
                    return [];
                }

                return [
                    Forms\Components\Select::make('approver_id')
                        ->label('Gerente Solicitante (Aprobador)')
                        ->options(User::withRole('aprueba_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Solo usuarios con rol "Aprueba Requisición de Compra"'),

                    Forms\Components\Select::make('authorizer_id')
                        ->label('Director (Autorizador)')
                        ->options(User::withRole('autoriza_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Solo usuarios con rol "Autoriza Requisición de Compra"'),

                    Forms\Components\Placeholder::make('current_info')
                        ->label('Cadena Actual')
                        ->content("Aprueba: {$order->requisition->approvalChain->approver->name} | Autoriza: {$order->requisition->approvalChain->authorizer?->name}"),

                    Forms\Components\Placeholder::make('info')
                        ->content('⚠️ Esta nueva cadena se asignará a la requisición actual y la orden volverá al inicio del proceso.'),
                ];
            })
            ->action(function (array $data, Action $action) {
                $orderId = $action->getArguments()['order'];
                $order = PurchaseOrder::find($orderId);

                if (! $order || ! $order->requisition) {
                    return;
                }

                $requisition = $order->requisition;
                $requesterId = $requisition->approvalChain->requester_id;
                $oldChainId = $requisition->approval_chain_id;

                // Crear nueva cadena
                $newChain = PurchaseRequisitionApprovalChain::create([
                    'requester_id' => $requesterId,
                    'reviewer_id' => User::withRole('revisa_requisicion_compra')->value('id') ?? $requesterId,
                    'approver_id' => $data['approver_id'],
                    'authorizer_id' => $data['authorizer_id'],
                ]);

                // Asignar la nueva cadena a la requisición actual
                $requisition->approval_chain_id = $newChain->id;
                $requisition->save();

                $oldChain = PurchaseRequisitionApprovalChain::find($oldChainId);

                // Transicionar al nuevo estado 'cadena reasignada' con metadata
                $order->status()->transitionTo('cadena reasignada', [
                    'comments' => "Nueva cadena de aprobación creada y asignada. Anterior: Aprueba {$oldChain?->approver->name}, Autoriza {$oldChain?->authorizer->name}. Nueva: Aprueba {$newChain->approver->name}, Autoriza {$newChain->authorizer->name}. Cadena creada por ".auth()->user()->name,
                    'old_chain_id' => $oldChainId,
                    'new_chain_id' => $newChain->id,
                    'old_approver_id' => $oldChain?->approver_id,
                    'old_authorizer_id' => $oldChain?->authorizer_id,
                    'new_approver_id' => $newChain->approver_id,
                    'new_authorizer_id' => $newChain->authorizer_id,
                    'reassigned_by' => auth()->user()->id,
                    'reassigned_at' => now(),
                    'chain_created' => true,
                ]);

                // Transicionar inmediatamente al estado inicial del proceso
                $order->status()->transitionTo('revisión gerente de compras');

                Notification::make()
                    ->title('Cadena creada y asignada')
                    ->body("Nueva cadena #{$newChain->id} creada y asignada a requisición #{$requisition->folio}. Orden {$order->folio} reiniciada")
                    ->success()
                    ->send();

                $this->analyzeUser();
            })
            ->modalHeading('Crear Nueva Cadena de Aprobación')
            ->modalDescription('Defina los usuarios que formarán parte de la nueva cadena de aprobación')
            ->modalSubmitActionLabel('Crear y Asignar')
            ->modalWidth('2xl');
    }
}
