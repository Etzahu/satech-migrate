<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use App\Filament\Purchases\Resources\ProductResource;
use App\Models\CategoryFamily;
use App\Models\Product;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->authorizationTooltip(),
        ];
    }

    /**
     * Filament arma estos botones al inicio de cada petición, antes de que la
     * respuesta cambie el estatus. Por eso se registran siempre y cada uno
     * decide con visible(), que se evalúa al dibujar la página: así, al aprobar,
     * "Capturar respuesta" cede su lugar a "Guardar" sin recargar.
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->visible(fn (): bool => $this->record->status === 'pendiente')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado' => 'Aprobar',
                            'rechazado' => 'Rechazar',
                        ])
                        ->default('aprobado')
                        ->required(),
                    Textarea::make('observation')
                        ->label('Observación')
                        ->helperText('Obligatoria al rechazar. El solicitante la verá en su solicitud y en el correo.')
                        ->requiredUnless('response', 'aprobado')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->maxLength(600),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    // Rechazar no pide clasificar: código, categoría y familia
                    // solo hacen falta para lo que entra al catálogo.
                    if ($data['response'] === 'rechazado') {
                        $this->record->status()->transitionTo('rechazado', ['respuesta' => $data['observation']]);

                        Notification::make()
                            ->title('Solicitud rechazada')
                            ->success()
                            ->send();

                        return redirect(ProductResource::getUrl('index'));
                    }

                    $dataUpdate = $this->form->getState();

                    $this->record->status()->transitionTo('aprobado', ['respuesta' => $data['observation']]);
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
            $this->getSaveFormAction()
                ->visible(fn (): bool => $this->record->status === 'aprobado'),
        ];
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
