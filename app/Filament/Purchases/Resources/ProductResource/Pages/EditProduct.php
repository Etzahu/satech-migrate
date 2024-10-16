<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\CategoryFamily;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\ProductResource;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = $this->generateCode($data['category_family_id']);
        return $data;
    }

    protected function generateCode($categoryCodeId)
    {
        $familyItem = CategoryFamily::with('category')->find($categoryCodeId);
        $codeCategory = $familyItem->category->code;
        $codeFamily = $familyItem->code;
        $numberRecord = Product::where('category_family_id', $categoryCodeId)->count() + 1;
        $code = $codeCategory . $codeFamily . Str::of($numberRecord)->padRight(4, 0); ;
        return $code;
    }
}
