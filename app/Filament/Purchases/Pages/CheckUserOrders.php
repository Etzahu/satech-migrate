<?php

namespace App\Filament\Purchases\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Pages\Page;
use App\Models\PurchaseOrder;
use Illuminate\Support\Collection;
use App\Models\PurchaseRequisition;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Actions\Concerns\InteractsWithActions;

class CheckUserOrders extends Page implements HasForms, HasActions
{
  use InteractsWithForms;
  use InteractsWithActions;

  protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

  protected static string $view = 'filament.purchases.pages.check-user-orders';

  protected static ?string $navigationLabel = 'Verificar Órdenes de Usuario';

  protected static ?string $title = 'Verificar Órdenes de Compra Bloqueadas';

  protected static ?string $navigationGroup = 'Administración';

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

  public function form(Forms\Form $form): Forms\Form
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
    if (!$this->selectedUserId) {
      $this->resetStats();
      return;
    }

    $user = User::find($this->selectedUserId);

    if (!$user) {
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
   * Acción para cambiar la requisición de una orden de compra
   */
  public function reassignOrderRequisitionAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('reassignOrderRequisition')
      ->label('Cambiar Requisición')
      ->icon('heroicon-o-arrow-path-rounded-square')
      ->color('warning')
      ->form(function (\Filament\Actions\Action $action) {
        $orderId = $action->getArguments()['order'];
        $order = PurchaseOrder::find($orderId);

        if (!$order || !$order->requisition) {
          return [];
        }

        $requesterId = $order->requisition->approvalChain->requester_id;
        $currentRequisitionId = $order->requisition_id;

        // Buscar requisiciones del mismo solicitante que estén autorizadas
        $availableRequisitions = PurchaseRequisition::where('requester_id', $requesterId)
          ->where('id', '!=', $currentRequisitionId)
          ->whereIn('status', ['autorizada', 'con orden parcial', 'con orden total'])
          ->where('company_id', session()->get('company_id'))
          ->with('approvalChain')
          ->get()
          ->mapWithKeys(function ($req) {
            return [
              $req->id => "Req #{$req->folio} - Aprueba: {$req->approvalChain->approver->name}, Autoriza: {$req->approvalChain->authorizer->name}"
            ];
          })
          ->toArray();

        $fields = [];

        if (count($availableRequisitions) > 0) {
          $fields[] = Forms\Components\Select::make('new_requisition_id')
            ->label('Seleccionar nueva requisición')
            ->options($availableRequisitions)
            ->required()
            ->helperText('Seleccione la requisición (y su cadena) que se asignará a esta orden');

          $fields[] = Forms\Components\Placeholder::make('current_info')
            ->label('Cadena Actual')
            ->content("Aprueba: {$order->requisition->approvalChain->approver->name} | Autoriza: {$order->requisition->approvalChain->authorizer->name}");

          $fields[] = Forms\Components\Placeholder::make('info')
            ->content('💡 Al cambiar la requisición, la orden volverá al inicio del proceso de aprobación con la nueva cadena.');
        } else {
          $fields[] = Forms\Components\Placeholder::make('warning')
            ->content('⚠️ No hay otras requisiciones autorizadas del mismo solicitante disponibles.');
        }

        return $fields;
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $orderId = $action->getArguments()['order'];
        $order = PurchaseOrder::find($orderId);

        if ($order && isset($data['new_requisition_id'])) {
          $order->reassignAndReset($data['new_requisition_id']);

          \Filament\Notifications\Notification::make()
            ->title('Requisición reasignada')
            ->body("La orden {$order->folio} ha sido reasignada y regresada al inicio")
            ->success()
            ->send();

          $this->analyzeUser();
        }
      })
      ->modalHeading('Cambiar Requisición de la Orden')
      ->modalDescription('Seleccione una nueva requisición autorizada para esta orden')
      ->modalSubmitActionLabel('Cambiar y Resetear')
      ->modalWidth('2xl');
  }
}
