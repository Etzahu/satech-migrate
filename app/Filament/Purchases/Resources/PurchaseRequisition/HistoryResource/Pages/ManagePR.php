<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManagePR extends ManageRecords
{
    protected static string $resource = HistoryResource::class;

    public function getTabs(): array
    {
        $tabs = [];

        if (auth()->user()->hasRole('solicita_requisicion_compra')) {
            $tabs['myRequisitions'] = Tab::make('Mis requisiciones')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        $query
                            ->whereIn('approval_chain_id', auth()->user()->approvalChainsPurchaseRequisition->pluck('id')->toArray())
                            ->where('company_id', session()->get('company_id'))
                            ->whereNotIn('status', [
                                'borrador',
                                'devuelto por almacén',
                                'devuelto por revisor',
                                'devuelto por gerencia',
                                'devuelto por DG',
                                'devuelto por comprador'
                            ])
                            ->orderBy('id', 'desc');
                    }
                );
        }
        if (auth()->user()->hasRole('revisa_almacen_requisicion_compra')) {
            $tabs['revisionsWarehouse'] = Tab::make('Revisiones-almacén')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('revisión por almacén');
                        });
                });
        }
        if (auth()->user()->hasRole('revisa_requisicion_compra')) {
            $tabs['revisions'] = Tab::make('Revisiones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->whereIn('approval_chain_id', auth()->user()->reviewerChainsPR->pluck('id')->toArray())
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('revisión');
                        });
                });
        }
        if (auth()->user()->hasRole('aprueba_requisicion_compra')) {
            $tabs['approvals'] = Tab::make('Aprobaciones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->whereIn('approval_chain_id', auth()->user()->approverChainsPR->pluck('id')->toArray())
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por revisor');
                        });
                });
        }
        if (auth()->user()->hasRole('autoriza_requisicion_compra')) {
            $tabs['authorizations'] =  Tab::make('Autorizaciones')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->whereIn('approval_chain_id', auth()->user()->authorizerChainsPR->pluck('id')->toArray())
                        ->where('company_id', session()->get('company_id'))
                        ->whereHasStatus(function ($query) {
                            $query
                                ->from('aprobado por revisor');
                        });
                });
        }
        if (auth()->user()->hasRole('gerente_compras') ||auth()->user()->hasRole('administrador_compras') ||auth()->user()->id == 106) {
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
