<?php

namespace App\Filament\Purchases\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Models\PurchaseRequisition;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Actions\Concerns\InteractsWithActions;
use App\Services\PurchaseRequisitionCreationService;
use App\Mail\PurchaseRequisition\Notification;

class CheckUserRequisitions extends Page implements HasForms, HasActions
{
  use InteractsWithForms;
  use InteractsWithActions;

  protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

  protected static string $view = 'filament.purchases.pages.check-user-requisitions';

  protected static ?string $navigationLabel = 'Verificar requisicion usuario';

  protected static ?string $title = 'Verificar Requisiciones de Usuario';

  protected static ?string $navigationGroup = 'Administración';

  protected static ?int $navigationSort = 99;

  public ?int $selectedUserId = null;

  public ?array $data = [];

  public array $userStats = [
    'chains_as_reviewer' => 0,
    'chains_as_approver' => 0,
    'chains_as_authorizer' => 0,
    'pending_to_review' => 0,
    'pending_to_approve' => 0,
    'pending_to_authorize' => 0,
  ];

  public Collection $requisitionsToReview;
  public Collection $requisitionsToApprove;
  public Collection $requisitionsToAuthorize;

  public ?int $reassignRequisitionId = null;
  public ?int $newChainId = null;
  public bool $showReassignModal = false;
  public bool $showCreateChainModal = false;
  public array $availableChains = [];
  public array $chainData = [
    'reviewer_id' => null,
    'approver_id' => null,
    'authorizer_id' => null,
  ];

  public function mount(): void
  {
    $this->form->fill();
    $this->requisitionsToReview = collect();
    $this->requisitionsToApprove = collect();
    $this->requisitionsToAuthorize = collect();
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

    // Buscar cadenas donde el usuario participa
    $chainsAsReviewer = PurchaseRequisitionApprovalChain::where('reviewer_id', $this->selectedUserId)->get();
    $chainsAsApprover = PurchaseRequisitionApprovalChain::where('approver_id', $this->selectedUserId)->get();
    $chainsAsAuthorizer = PurchaseRequisitionApprovalChain::where('authorizer_id', $this->selectedUserId)->get();

    // Obtener requisiciones pendientes filtradas por compañía
    $this->requisitionsToReview = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsReviewer->pluck('id'))
      ->where('status', 'revisión')
      ->where('company_id', $companyId)
      ->with(['approvalChain.requester', 'company'])
      ->get();

    $this->requisitionsToApprove = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsApprover->pluck('id'))
      ->where('status', 'aprobado por revisor')
      ->where('company_id', $companyId)
      ->with(['approvalChain.requester', 'company'])
      ->get();

    $this->requisitionsToAuthorize = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsAuthorizer->pluck('id'))
      ->where('status', 'aprobado por gerencia')
      ->where('company_id', $companyId)
      ->with(['approvalChain.requester', 'company'])
      ->get();

    // Actualizar estadísticas
    $this->userStats = [
      'chains_as_reviewer' => $chainsAsReviewer->count(),
      'chains_as_approver' => $chainsAsApprover->count(),
      'chains_as_authorizer' => $chainsAsAuthorizer->count(),
      'pending_to_review' => $this->requisitionsToReview->count(),
      'pending_to_approve' => $this->requisitionsToApprove->count(),
      'pending_to_authorize' => $this->requisitionsToAuthorize->count(),
    ];
  }

  protected function resetStats(): void
  {
    $this->userStats = [
      'chains_as_reviewer' => 0,
      'chains_as_approver' => 0,
      'chains_as_authorizer' => 0,
      'pending_to_review' => 0,
      'pending_to_approve' => 0,
      'pending_to_authorize' => 0,
    ];
    $this->requisitionsToReview = collect();
    $this->requisitionsToApprove = collect();
    $this->requisitionsToAuthorize = collect();
  }

  public function getTotalPendingRequisitions(): int
  {
    return $this->userStats['pending_to_review']
      + $this->userStats['pending_to_approve']
      + $this->userStats['pending_to_authorize'];
  }

  public function getTotalChains(): int
  {
    return $this->userStats['chains_as_reviewer']
      + $this->userStats['chains_as_approver']
      + $this->userStats['chains_as_authorizer'];
  }

  public function reassignAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('reassign')
      ->label('Reasignar')
      ->icon('heroicon-o-arrow-path')
      ->color('warning')
      ->form(function (\Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return [];
        }

        $requesterId = $requisition->approvalChain->requester_id;
        $currentChainId = $requisition->approval_chain_id;

        $availableChains = PurchaseRequisitionApprovalChain::where('requester_id', $requesterId)
          ->where('id', '!=', $currentChainId)
          ->get()
          ->mapWithKeys(function ($chain) {
            return [
              $chain->id => "Cadena #{$chain->id} - Revisa: {$chain->reviewer->name}, Aprueba: {$chain->approver->name}, Autoriza: {$chain->authorizer->name}"
            ];
          })
          ->toArray();

        $fields = [];

        if (count($availableChains) > 0) {
          $fields[] = Forms\Components\Select::make('new_chain_id')
            ->label('Seleccionar cadena de aprobación')
            ->options($availableChains)
            ->required()
            ->helperText('Seleccione la nueva cadena de aprobación para esta requisición');

          $fields[] = Forms\Components\Placeholder::make('info')
            ->content('💡 Al reasignar, la requisición volverá al estado inicial del proceso de aprobación.');
        } else {
          $fields[] = Forms\Components\Placeholder::make('warning')
            ->content('⚠️ No hay cadenas de aprobación disponibles para este solicitante. Use la acción "Crear Nueva Cadena" en su lugar.');
        }

        return $fields;
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if ($requisition && isset($data['new_chain_id'])) {
          $requisition->reassignAndReset($data['new_chain_id']);

          \Filament\Notifications\Notification::make()
            ->title('Reasignación exitosa')
            ->body("La requisición {$requisition->folio} ha sido reasignada y regresada al inicio")
            ->success()
            ->send();

          $this->analyzeUser();
        }
      })
      ->modalHeading('Reasignar Requisición')
      ->modalDescription('Seleccione una cadena de aprobación existente para esta requisición')
      ->modalSubmitActionLabel('Reasignar y Resetear')
      ->modalWidth('2xl');
  }

  public function createChainAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('createChain')
      ->label('Crear Nueva Cadena')
      ->icon('heroicon-o-plus-circle')
      ->color('success')
      ->form(function (\Filament\Actions\Action $action) {
        return [
          Forms\Components\Select::make('reviewer_id')
            ->label('Revisor')
            ->options(User::role('revisa_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Revisa Requisición de Compra"'),

          Forms\Components\Select::make('approver_id')
            ->label('Aprobador')
            ->options(User::role('aprueba_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Aprueba Requisición de Compra"'),

          Forms\Components\Select::make('authorizer_id')
            ->label('Autorizador')
            ->options(User::role('autoriza_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Autoriza Requisición de Compra"'),

          Forms\Components\Placeholder::make('info')
            ->content('⚠️ Esta cadena se creará para el solicitante de la requisición y luego se reasignará automáticamente.'),
        ];
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return;
        }

        // Crear nueva cadena
        $newChain = PurchaseRequisitionApprovalChain::create([
          'requester_id' => $requisition->approvalChain->requester_id,
          'reviewer_id' => $data['reviewer_id'],
          'approver_id' => $data['approver_id'],
          'authorizer_id' => $data['authorizer_id'],
        ]);

        // Reasignar requisición
        $requisition->reassignAndReset($newChain->id);

        \Filament\Notifications\Notification::make()
          ->title('Cadena creada y reasignada')
          ->body("Nueva cadena #{$newChain->id} creada y requisición {$requisition->folio} reasignada")
          ->success()
          ->send();

        $this->analyzeUser();
      })
      ->modalHeading('Crear Nueva Cadena de Aprobación')
      ->modalDescription('Defina los usuarios que formarán parte de la nueva cadena de aprobación')
      ->modalSubmitActionLabel('Crear y Reasignar')
      ->modalWidth('2xl');
  }

  public function openReassignModal(int $requisitionId): void
  {
    $this->reassignRequisitionId = $requisitionId;
    $requisition = PurchaseRequisition::find($requisitionId);

    if (!$requisition) {
      return;
    }

    // Obtener cadenas disponibles para el solicitante
    $requesterId = $requisition->approvalChain->requester_id;
    $currentChainId = $requisition->approval_chain_id;

    $this->availableChains = PurchaseRequisitionApprovalChain::where('requester_id', $requesterId)
      ->where('id', '!=', $currentChainId)
      ->get()
      ->mapWithKeys(function ($chain) {
        return [
          $chain->id => "Cadena #{$chain->id} - Revisa: {$chain->reviewer->name}, Aprueba: {$chain->approver->name}, Autoriza: {$chain->authorizer->name}"
        ];
      })
      ->toArray();

    $this->showReassignModal = true;
  }

  public function reassignRequisition(): void
  {
    if (!$this->reassignRequisitionId || !$this->newChainId) {
      \Filament\Notifications\Notification::make()
        ->title('Error')
        ->body('Debe seleccionar una cadena de aprobación')
        ->danger()
        ->send();
      return;
    }

    $requisition = PurchaseRequisition::find($this->reassignRequisitionId);

    if ($requisition) {
      $requisition->reassignAndReset($this->newChainId);

      \Filament\Notifications\Notification::make()
        ->title('Reasignación exitosa')
        ->body("La requisición {$requisition->folio} ha sido reasignada y regresada al inicio")
        ->success()
        ->send();

      $this->closeReassignModal();
      $this->analyzeUser(); // Refrescar datos
    }
  }

  public function closeReassignModal(): void
  {
    $this->showReassignModal = false;
    $this->reassignRequisitionId = null;
    $this->newChainId = null;
    $this->availableChains = [];
  }

  public function openCreateChainModal(): void
  {
    $this->showCreateChainModal = true;
  }

  public function closeCreateChainModal(): void
  {
    $this->showCreateChainModal = false;
    $this->chainData = [
      'reviewer_id' => null,
      'approver_id' => null,
      'authorizer_id' => null,
    ];
  }

  public function createChainAndReassign(): void
  {
    if (!$this->reassignRequisitionId) {
      return;
    }

    // Validar datos
    if (!$this->chainData['reviewer_id'] || !$this->chainData['approver_id'] || !$this->chainData['authorizer_id']) {
      \Filament\Notifications\Notification::make()
        ->title('Error')
        ->body('Debe seleccionar todos los roles de la cadena')
        ->danger()
        ->send();
      return;
    }

    $requisition = PurchaseRequisition::find($this->reassignRequisitionId);

    if (!$requisition) {
      return;
    }

    // Crear nueva cadena
    $newChain = PurchaseRequisitionApprovalChain::create([
      'requester_id' => $requisition->approvalChain->requester_id,
      'reviewer_id' => $this->chainData['reviewer_id'],
      'approver_id' => $this->chainData['approver_id'],
      'authorizer_id' => $this->chainData['authorizer_id'],
    ]);

    // Reasignar requisición
    $requisition->reassignAndReset($newChain->id);

    \Filament\Notifications\Notification::make()
      ->title('Cadena creada y reasignada')
      ->body("Nueva cadena #{$newChain->id} creada y requisición {$requisition->folio} reasignada")
      ->success()
      ->send();

    $this->closeCreateChainModal();
    $this->closeReassignModal();
    $this->analyzeUser();
  }

  protected function getReassignFormSchema(): array
  {
    return [
      Forms\Components\Select::make('newChainId')
        ->label('Seleccionar cadena de aprobación')
        ->options($this->availableChains)
        ->required()
        ->helperText('Seleccione la nueva cadena de aprobación para esta requisición'),
    ];
  }

  protected function getCreateChainFormSchema(): array
  {
    return [
      Forms\Components\Select::make('reviewer_id')
        ->label('Revisor')
        ->options(User::orderBy('name')->pluck('name', 'id'))
        ->searchable()
        ->required(),

      Forms\Components\Select::make('approver_id')
        ->label('Aprobador')
        ->options(User::orderBy('name')->pluck('name', 'id'))
        ->searchable()
        ->required(),

      Forms\Components\Select::make('authorizer_id')
        ->label('Autorizador')
        ->options(User::orderBy('name')->pluck('name', 'id'))
        ->searchable()
        ->required(),
    ];
  }

  /**
   * Acción para reasignar requisiciones pendientes de APROBAR
   */
  public function reassignApproveAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('reassignApprove')
      ->label('Reasignar')
      ->icon('heroicon-o-arrow-path')
      ->color('success')
      ->form(function (\Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return [];
        }

        $requesterId = $requisition->approvalChain->requester_id;
        $currentChainId = $requisition->approval_chain_id;

        $availableChains = PurchaseRequisitionApprovalChain::where('requester_id', $requesterId)
          ->where('id', '!=', $currentChainId)
          ->get()
          ->mapWithKeys(function ($chain) {
            return [
              $chain->id => "Cadena #{$chain->id} - Revisa: {$chain->reviewer->name}, Aprueba: {$chain->approver->name}, Autoriza: {$chain->authorizer->name}"
            ];
          })
          ->toArray();

        $fields = [];

        if (count($availableChains) > 0) {
          $fields[] = Forms\Components\Select::make('new_chain_id')
            ->label('Seleccionar cadena de aprobación')
            ->options($availableChains)
            ->required()
            ->helperText('Seleccione la nueva cadena de aprobación para esta requisición');

          $fields[] = Forms\Components\Placeholder::make('info')
            ->content('💡 Al reasignar, la requisición volverá al estado inicial del proceso de aprobación.');
        } else {
          $fields[] = Forms\Components\Placeholder::make('warning')
            ->content('⚠️ No hay cadenas de aprobación disponibles para este solicitante. Use la acción "Crear Nueva Cadena" en su lugar.');
        }

        return $fields;
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if ($requisition && isset($data['new_chain_id'])) {
          $requisition->reassignAndReset($data['new_chain_id']);

          \Filament\Notifications\Notification::make()
            ->title('Reasignación exitosa')
            ->body("La requisición {$requisition->folio} ha sido reasignada y regresada al inicio")
            ->success()
            ->send();

          $this->analyzeUser();
        }
      })
      ->modalHeading('Reasignar Requisición')
      ->modalDescription('Seleccione una cadena de aprobación existente para esta requisición')
      ->modalSubmitActionLabel('Reasignar y Resetear')
      ->modalWidth('2xl');
  }

  /**
   * Acción para crear nueva cadena para requisiciones pendientes de APROBAR
   */
  public function createChainApproveAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('createChainApprove')
      ->label('Crear Nueva Cadena')
      ->icon('heroicon-o-plus-circle')
      ->color('success')
      ->form(function (\Filament\Actions\Action $action) {
        return [
          Forms\Components\Select::make('reviewer_id')
            ->label('Revisor')
            ->options(User::role('revisa_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Revisa Requisición de Compra"'),

          Forms\Components\Select::make('approver_id')
            ->label('Aprobador')
            ->options(User::role('aprueba_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Aprueba Requisición de Compra"'),

          Forms\Components\Select::make('authorizer_id')
            ->label('Autorizador')
            ->options(User::role('autoriza_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Autoriza Requisición de Compra"'),

          Forms\Components\Placeholder::make('info')
            ->content('⚠️ Esta cadena se creará para el solicitante de la requisición y luego se reasignará automáticamente.'),
        ];
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return;
        }

        // Crear nueva cadena
        $newChain = PurchaseRequisitionApprovalChain::create([
          'requester_id' => $requisition->approvalChain->requester_id,
          'reviewer_id' => $data['reviewer_id'],
          'approver_id' => $data['approver_id'],
          'authorizer_id' => $data['authorizer_id'],
        ]);

        // Reasignar requisición
        $requisition->reassignAndReset($newChain->id);

        \Filament\Notifications\Notification::make()
          ->title('Cadena creada y reasignada')
          ->body("Nueva cadena #{$newChain->id} creada y requisición {$requisition->folio} reasignada")
          ->success()
          ->send();

        $this->analyzeUser();
      })
      ->modalHeading('Crear Nueva Cadena de Aprobación')
      ->modalDescription('Defina los usuarios que formarán parte de la nueva cadena de aprobación')
      ->modalSubmitActionLabel('Crear y Reasignar')
      ->modalWidth('2xl');
  }

  /**
   * Acción para reasignar requisiciones pendientes de AUTORIZAR
   */
  public function reassignAuthorizeAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('reassignAuthorize')
      ->label('Reasignar')
      ->icon('heroicon-o-arrow-path')
      ->color('primary')
      ->form(function (\Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return [];
        }

        $requesterId = $requisition->approvalChain->requester_id;
        $currentChainId = $requisition->approval_chain_id;

        $availableChains = PurchaseRequisitionApprovalChain::where('requester_id', $requesterId)
          ->where('id', '!=', $currentChainId)
          ->get()
          ->mapWithKeys(function ($chain) {
            return [
              $chain->id => "Cadena #{$chain->id} - Revisa: {$chain->reviewer->name}, Aprueba: {$chain->approver->name}, Autoriza: {$chain->authorizer->name}"
            ];
          })
          ->toArray();

        $fields = [];

        if (count($availableChains) > 0) {
          $fields[] = Forms\Components\Select::make('new_chain_id')
            ->label('Seleccionar cadena de aprobación')
            ->options($availableChains)
            ->required()
            ->helperText('Seleccione la nueva cadena de aprobación para esta requisición');

          $fields[] = Forms\Components\Placeholder::make('info')
            ->content('💡 Al reasignar, la requisición volverá al estado inicial del proceso de aprobación.');
        } else {
          $fields[] = Forms\Components\Placeholder::make('warning')
            ->content('⚠️ No hay cadenas de aprobación disponibles para este solicitante. Use la acción "Crear Nueva Cadena" en su lugar.');
        }

        return $fields;
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if ($requisition && isset($data['new_chain_id'])) {
          $requisition->reassignAndReset($data['new_chain_id']);

          \Filament\Notifications\Notification::make()
            ->title('Reasignación exitosa')
            ->body("La requisición {$requisition->folio} ha sido reasignada y regresada al inicio")
            ->success()
            ->send();

          $this->analyzeUser();
        }
      })
      ->modalHeading('Reasignar Requisición')
      ->modalDescription('Seleccione una cadena de aprobación existente para esta requisición')
      ->modalSubmitActionLabel('Reasignar y Resetear')
      ->modalWidth('2xl');
  }

  /**
   * Acción para crear nueva cadena para requisiciones pendientes de AUTORIZAR
   */
  public function createChainAuthorizeAction(): \Filament\Actions\Action
  {
    return \Filament\Actions\Action::make('createChainAuthorize')
      ->label('Crear Nueva Cadena')
      ->icon('heroicon-o-plus-circle')
      ->color('primary')
      ->form(function (\Filament\Actions\Action $action) {
        return [
          Forms\Components\Select::make('reviewer_id')
            ->label('Revisor')
            ->options(User::role('revisa_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Revisa Requisición de Compra"'),

          Forms\Components\Select::make('approver_id')
            ->label('Aprobador')
            ->options(User::role('aprueba_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Aprueba Requisición de Compra"'),

          Forms\Components\Select::make('authorizer_id')
            ->label('Autorizador')
            ->options(User::role('autoriza_requisicion_compra')->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->helperText('Solo usuarios con rol "Autoriza Requisición de Compra"'),

          Forms\Components\Placeholder::make('info')
            ->content('⚠️ Esta cadena se creará para el solicitante de la requisición y luego se reasignará automáticamente.'),
        ];
      })
      ->action(function (array $data, \Filament\Actions\Action $action) {
        $requisitionId = $action->getArguments()['requisition'];
        $requisition = PurchaseRequisition::find($requisitionId);

        if (!$requisition) {
          return;
        }

        // Crear nueva cadena
        $newChain = PurchaseRequisitionApprovalChain::create([
          'requester_id' => $requisition->approvalChain->requester_id,
          'reviewer_id' => $data['reviewer_id'],
          'approver_id' => $data['approver_id'],
          'authorizer_id' => $data['authorizer_id'],
        ]);

        // Reasignar requisición
        $requisition->reassignAndReset($newChain->id);

        \Filament\Notifications\Notification::make()
          ->title('Cadena creada y reasignada')
          ->body("Nueva cadena #{$newChain->id} creada y requisición {$requisition->folio} reasignada")
          ->success()
          ->send();

        $this->analyzeUser();
      })
      ->modalHeading('Crear Nueva Cadena de Aprobación')
      ->modalDescription('Defina los usuarios que formarán parte de la nueva cadena de aprobación')
      ->modalSubmitActionLabel('Crear y Reasignar')
      ->modalWidth('2xl');
  }
}
