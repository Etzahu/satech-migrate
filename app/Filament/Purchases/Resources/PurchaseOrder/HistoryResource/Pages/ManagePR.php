<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource;
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
        if (auth()->user()->hasRole('gerente_solicitante_orden_compra')) {
            $tabs['revisions'] = Tab::make('Revisiones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->withWhereHas('requisition', function ($query) {
                            $query->whereHas('approvalChain', function ($query) {
                                $query->where('approver_id', auth()->user()->id);
                            });
                        })
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por gerente solicitante');
                        })->orderBy('id', 'desc');
                });
        }
        if (auth()->user()->hasRole('autoriza_nivel-1-orden_compra')) {
            $tabs['authorizations'] = Tab::make('Autorizaciones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->withWhereHas('requisition', function ($query) {
                            $query->whereHas('approvalChain', function ($query) {
                                $query->where('authorizer_id', auth()->user()->id);
                            });
                        })
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por DG nivel 1');
                        })->orderBy('id', 'desc');
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
            auth()->user()->id == 106 ||
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
