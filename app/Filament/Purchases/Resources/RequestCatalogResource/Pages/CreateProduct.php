<?php

namespace App\Filament\Purchases\Resources\RequestCatalogResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\CategoryFamily;
use App\Mail\CatalogNotification;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\RequestCatalogResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = RequestCatalogResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = 'Sin código asignado';
        $data['company_id'] = session()->get('company_id');
        $data['requester_id'] = auth()->user()->id;
        return $data;
    }
    //:void
    protected function afterCreate(): void
    {
        //   enviar correo al usuario que da de alta
        $this->record->load('company', 'requester', 'unit');
        $usersPurchase = User::role('administrador_compras')->get();


        $recipients = [];
        foreach ($usersPurchase as $user) {
            $recipients[] = $user->email;
        }
        Mail::to($recipients)->send(new CatalogNotification($this->record));
    }
}
