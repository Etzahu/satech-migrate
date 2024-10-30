<?php

namespace App\Filament\Purchases\Pages\PurchaseRequisition;

use Filament\Pages\Page;

class ApproveDG extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.purchases.pages.purchase-requisition.approve-d-g';
}
