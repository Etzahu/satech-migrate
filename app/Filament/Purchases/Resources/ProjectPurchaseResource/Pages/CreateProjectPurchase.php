<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use Filament\Actions;
use App\Models\Category;
use App\Models\CategoryFamily;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\ProjectPurchaseResource;

class CreateProjectPurchase extends CreateRecord
{
    protected static string $resource = ProjectPurchaseResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = session()->get('company_id');
        $data['code'] = str($data['code'])->squish()->upper();
        $data['name'] = str($data['name'])->squish()->upper();
        return $data;
    }
    protected function afterCreate(): void
    {
        // TODO: falta crear la forma de vincular las categorias con el tipo de proyecto, si empiezas con algo diferente a NP DN, por ejempro para proyectos de stock o servicios generales
        // dd(str($this->record)->startsWith('DN-'), str($this->record)->startsWith('NP-'));
        if (str($this->record->code)->startsWith('DN-') || str($this->record->code)->startsWith('NP-')) {
            $families = Category::withWhereHas('families', fn ($query) => $query->where('type', 'DN-NP'))
            ->get()
            ->pluck('id');
            $this->record->categories()->attach($families);
        }
    }
}
