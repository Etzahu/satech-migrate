<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource;

class ListPurchaseOrders extends ListRecords
{
  protected static string $resource = ApproveSpecialResource::class;

  protected function getHeaderActions(): array
  {
    return [];
  }
}
