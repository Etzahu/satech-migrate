<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\CategoryFamily;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['company_id'] = session()->get('company_id');
        $data['registered_user_id']= auth()->user()->id;
        $data['requester_id']= auth()->user()->id;
        $data['code'] = $data['automatic_code'] ? $this->generateCode($data['category_family_id']) : 'Sin código asignado';
        return $data;
    }

    protected function generateCode($categoryCodeId)
    {
        $familyItem = CategoryFamily::with('category')->find($categoryCodeId);
        $codeCategory = $familyItem->category->code;
        $codeFamily = $familyItem->code;
        $numberRecord = Product::where('category_family_id', $categoryCodeId)->count() + 1;
        $code = $codeCategory . $codeFamily . Str::of($numberRecord)->padLeft(4, 0);
        return $code;
    }
    protected function afterCreate(): void
    {
        $this->record->status()->transitionTo('aprobado');
    }


}
