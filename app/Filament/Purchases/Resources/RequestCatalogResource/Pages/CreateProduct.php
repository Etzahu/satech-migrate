<?php

namespace App\Filament\Purchases\Resources\RequestCatalogResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\CategoryFamily;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\RequestCatalogResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = RequestCatalogResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = 'Sin código asignado';
        $data['requester_id'] = auth()->user()->id;
        return $data;
    }
    protected function afterCreate(): void
    {
    //   enviar correo al usuario que da de alta 
    }
}
