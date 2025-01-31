<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use App\Models\CategoryFamily;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
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

    protected function getFormActions(): array
    {
        if ($this->record->status == 'pendiente') {
            return  [
                Action::make('Capturar respuesta')
                    ->modalHeading('Enviar respuesta')
                    ->color('success')

                    ->form([
                        Select::make('response')
                            ->label('Respuesta')
                            ->options([
                                'aprobado' => 'Aprobar',
                                'rechazado' => 'Rechazar',
                            ])
                            ->default('aprobado')
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data) {
                        $this->form->getState();
                        $dataUpdate = $this->form->getState();

                        $this->record->status()->transitionTo($data['response']);
                        $this->record->code = $dataUpdate['code'];
                        $this->record->category_id = $dataUpdate['category_id'];
                        $this->record->category_family_id = $dataUpdate['category_family_id'];
                        $this->record->brand_id = $dataUpdate['brand_id'];
                        $this->record->name = $dataUpdate['name'];
                        $this->record->unit_id = $dataUpdate['unit_id'];
                        $this->record->registered_user_id = auth()->user()->id;
                        $this->record->save();

                        Notification::make()
                            ->title('Respuesta enviada')
                            ->success()
                            ->send();
                        // return redirect(ApproverResource::getUrl('index'));
                    }),
            ];
        } elseif ($this->record->status == 'aprobado') {
            return [
                $this->getSaveFormAction(),
            ];
        } else {
            return [];
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['registered_user_id'] = auth()->user()->id;
        return $data;
    }

    // protected function generateCode($categoryCodeId)
    // {
    //     $familyItem = CategoryFamily::with('category')->find($categoryCodeId);
    //     $codeCategory = $familyItem->category->code;
    //     $codeFamily = $familyItem->code;
    //     $numberRecord = Product::where('category_family_id', $categoryCodeId)->count() + 1;
    //     $code = $codeCategory . $codeFamily . Str::of($numberRecord)->padRight(4, 0); ;
    //     return $code;
    // }
}
