<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseRequisitions extends ListRecords
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public function getTabs(): array
    // {
    //     $tabs = [];
    //     if(auth()->user()->hasRole('solicitante_requisicion_compra')) {
    //       $tabs['solicitadas'] = Tab::make('Mis requisiciones')
    //             ->modifyQueryUsing(fn(Builder $query) => $query->myRequisitions());
    //     }
    //     if(auth()->user()->hasRole('revisor_almacen_requisicion_compra')) {
    //         $tabs['revisar-almacen'] = Tab::make('Revisar por almacén')
    //             ->modifyQueryUsing(fn(Builder $query) => $query->reviewWarehouse());
    //     }
    //     if(auth()->user()->hasRole('revisor_requisicion_compra')) {
    //         $tabs['revisar'] = Tab::make('Revisar')
    //         ->modifyQueryUsing(fn(Builder $query) => $query->review());
    //     }
    //     if(auth()->user()->hasRole('autorizador_requisicion_compra')) {
    //        $tabs['autorizar'] = Tab::make('Autorizar');
    //     }
    //     if(auth()->user()->hasRole('director_general_requisicion_compra')) {
    //         $tabs['autorizar-dg'] = Tab::make('Autorizar DG');
    //     }
    //     return $tabs;
    // }
}
