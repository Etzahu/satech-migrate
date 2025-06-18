<?php

namespace App\Filament\Purchases\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\PurchaseOrder;
use Illuminate\Support\Collection;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions;

class Test extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.purchases.pages.test';

    public  $currentOrder = null;
    public  $orders;
    public int $currentIndex = 0;
    public array $items = [];

    public static function canAccess(): bool
    {
        return auth()->user()->id == 199;
    }
    public function mount(): void
    {
        //  parent::mount();
        // Load all orders
        $this->orders = PurchaseOrder::has('items','=',1)
            ->with(['requisition.items.product', 'items'])
            ->where('company_id', 1)
            ->get();
        dd($this->orders?->toArray());
        // Establecer la primera orden como la actual
        $this->currentOrder = $this->orders->first();
        // dd($this->currentOrder->toArray());
        $this->currentIndex = 0;
        // Cargar los datos de las partidas de la orden actual
        $this->items = filled($this->currentOrder) ? $this->currentOrder->items->toArray() : [];
        $this->form->fill(['order_id' => $this->currentOrder->id, 'folio' => $this->currentOrder->folio, 'items' => $this->items]);
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('folio')
                            ->label('Orden')
                            ->disabled()
                            ->default($this->currentOrder ? $this->currentOrder->id : null),
                        Forms\Components\Repeater::make('items')
                            // ->relationship('items')
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false)
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->label('id')
                                    ->readonly()
                                    ->required(),
                                Forms\Components\TextInput::make('product_id')
                                    ->label('Producto')
                                    ->readonly()
                                    ->required(),
                                Forms\Components\Select::make('pr_item_id_reference')
                                    ->options(function () {
                                        return $this->currentOrder->requisition->items->pluck('product_id', 'id');
                                    })
                                    ->required(),
                            ])
                            ->columns(3)
                            ->default($this->items),
                    ]),
            ])
            ->statePath('items');
    }

    public function save(): void
    {
        // Guardar los cambios en las partidas
        $this->currentOrder->items()->delete();
        foreach ($this->items as $item) {
            $this->currentOrder->items()->create($item);
        }

        // Mostrar notificación de éxito
        $this->notify('success', 'Partidas guardadas correctamente.');
    }

    public function nextOrder(): void
    {
        // Avanzar a la siguiente orden
        if ($this->currentIndex < $this->orders->count() - 1) {
            $this->currentIndex++;
            $this->currentOrder = $this->orders[$this->currentIndex];
            $this->items = $this->currentOrder->items->toArray();
            $this->form->fill(['order_id' => $this->currentOrder->id, 'folio' => $this->currentOrder->folio, 'items' => $this->items]);
        }
    }

    public function previousOrder(): void
    {
        // Retroceder a la orden anterior
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->currentOrder = $this->orders[$this->currentIndex];
            $this->items = $this->currentOrder->items->toArray();
            $this->form->fill(['order_id' => $this->currentOrder->id, 'folio' => $this->currentOrder->folio, 'items' => $this->items]);
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('previous')
                ->label('Anterior')
                ->action('previousOrder')
                ->disabled(fn() => $this->currentIndex === 0),
            Actions\Action::make('next')
                ->label('Siguiente')
                ->action('nextOrder')
                ->disabled(fn() => $this->currentIndex === $this->orders->count() - 1),
            Actions\Action::make('save')
                ->label('Guardar')
                ->action('save'),
        ];
    }
}
