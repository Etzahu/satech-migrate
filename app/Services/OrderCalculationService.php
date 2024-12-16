<?php

namespace App\Services;

use Money\Money;
use Money\Currency;
use App\Models\Company;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class OrderCalculationService
{
    public $order;
    public function __construct($id)
    {
        $this->order = PurchaseOrder::with(['items'])->find($id);
    }
    public function getItems()
    {
        $items = $this->order->items;
        $total =  new Money(0, new Currency($this->order->currency));
        foreach ($items as $item) {
            $total = $total->add(new Money($item->sub_total, new Currency($this->order->currency)));
        }
        return $total;
        // Se utiliza por ejemplo para imprimir en una vista blade, PDF
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter('es_MX', \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        dd($total->getAmount(),$moneyFormatter->format($total));
    }
}
