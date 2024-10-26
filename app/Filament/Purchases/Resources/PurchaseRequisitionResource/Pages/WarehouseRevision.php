<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisitionResource;
use Filament\Resources\Pages\Page;

class WarehouseRevision extends Page
{
    protected static string $resource = PurchaseRequisitionResource::class;

    protected static string $view = 'filament.purchases.resources.purchase-requisition-resource.pages.warehouse-revision';
}
