<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource;
use App\Services\PurchaseInformedService;
use App\Services\PurchaseOrderChainResolver;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManagePR extends ManageRecords
{
    protected static string $resource = HistoryResource::class;

    public function getTabs(): array
    {

        $tabs = [];
        if (auth()->user()->hasRole('comprador')) {
            $tabs['myRequisitions'] = Tab::make('Mis órdenes')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        $query
                            ->myRequisitions()
                            ->orderBy('id', 'desc');
                    }
                );
        }
        // Las dos pestañas de firma leen el mismo resolver que las bandejas:
        // bajo el flujo por rol, Alan y Sergio no están en la cadena y su
        // historial quedaría vacío si se filtrara por approver_id/authorizer_id.
        if (auth()->user()->hasRole('gerente_solicitante_orden_compra') ||
            auth()->user()->hasRole(PurchaseOrderChainResolver::APPROVER_ROLE)) {
            $tabs['revisions'] = Tab::make('Revisiones')
                ->modifyQueryUsing(function (Builder $query) {
                    return app(PurchaseOrderChainResolver::class)
                        ->applyApproverScope($query, auth()->user())
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por gerente solicitante');
                        })->orderBy('id', 'desc');
                });
        }
        if (auth()->user()->hasRole('autoriza_nivel-1-orden_compra') ||
            auth()->user()->hasRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE)) {
            $tabs['authorizations'] = Tab::make('Autorizaciones')
                ->modifyQueryUsing(function (Builder $query) {
                    return app(PurchaseOrderChainResolver::class)
                        ->applyAuthorizerScope($query, auth()->user())
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por DG nivel 1');
                        })->orderBy('id', 'desc');
                });
        }
        // Nivel informativo: ve las órdenes de su gerencia sin poder responder
        // nada. Excluye los borradores, que son la mesa de trabajo del comprador.
        if (auth()->user()->hasRole('informativo_compras')) {
            $tabs['informed'] = Tab::make('Informativo')
                ->modifyQueryUsing(function (Builder $query) {
                    return app(PurchaseInformedService::class)
                        ->applyOrderScope($query, auth()->user())
                        ->where('company_id', session()->get('company_id'))
                        ->whereNot('status', 'borrador')
                        ->orderBy('id', 'desc');
                });
        }
        if (auth()->user()->hasRole('autoriza_nivel-2-orden_compra')) {
            $tabs['authorizations'] = Tab::make('Autorizaciones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por DG nivel 2');
                        })->orderBy('id', 'desc');
                });
        }
        if (
            auth()->user()->hasRole('gerente_compras') ||
            auth()->user()->hasRole('administrador_compras') ||
            auth()->user()->hasRole('libera_orden_compra') ||
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('visor_ordenes')
        ) {
            $tabs['all'] = Tab::make('Todas')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        $query
                            ->where('company_id', session()->get('company_id'))
                            ->orderBy('id', 'desc');
                    }
                );
        }

        return $tabs;
    }
}
