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

    public $localeOptions = ['MXN' => 'es_MX', 'USD' => 'en_US',];
    public $locale;
    public function __construct($id)
    {
        $this->order = PurchaseOrder::with(['items'])->find($id);
        $this->locale = $this->localeOptions[$this->order->currency];

    }
    public function moneyFormatter($value)
    {
        // Se utiliza por ejemplo para imprimir en una vista blade, PDF
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $numberFormatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 4); // Mínimo 4 decimales
        $numberFormatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 4); // Máximo 4 decimales
        return $moneyFormatter->format($value);
    }
    public function getSubtotalItems($formatter = false)
    {
        $items = $this->order->items;
        $subtotal =  new Money(0, new Currency($this->order->currency));
        foreach ($items as $item) {
            $subtotal = $subtotal->add(new Money($item->sub_total, new Currency($this->order->currency)));
        }
        // $total =  $subtotal->subtract($this->getDiscountProvider());
        $total =  $subtotal;
        return $formatter ? $this->moneyFormatter($total) : $total;
    }

    public function subtotalDiscount($formatter = false)
    {
        $subtotal = $this->getSubtotalItems();
        $total = $subtotal->subtract($this->getDiscountProvider());

        return $formatter ? $this->moneyFormatter($total) : $total;
    }

    public function getTaxIva($formatter = false)
    {
        $subtotal = $this->subtotalDiscount();
        $result = $subtotal->multiply((string) ($this->order->tax_iva / 100));
        return $formatter ? $this->moneyFormatter($result) : $result;
    }

    public function getRetentionIva($formatter = false)
    {
        $subtotal =  $subtotal = $this->subtotalDiscount();
        $result = $subtotal->multiply((string) ($this->order->retention_iva / 100));
        return $formatter ? $this->moneyFormatter($result) : $result;
    }

    public function getRetentionIsr($formatter = false)
    {
        $subtotal =  $subtotal = $this->subtotalDiscount();
        $result = $subtotal->multiply((string) ($this->order->retention_isr / 100));

        return $formatter ? $this->moneyFormatter($result) : $result;
    }

    public function getDiscountProvider($formatter = false)
    {
        $result = new Money($this->order->discount, new Currency($this->order->currency));
        return $formatter ? $this->moneyFormatter($result) : $result;
    }
    public function getTotal($formatter = false)
    {
        $subtotal =  $subtotal = $this->subtotalDiscount();
        $total = $subtotal->add($this->getTaxIva());
        $total = $total->subtract($this->getRetentionIva(), $this->getRetentionIsr());
        // $test = $formatter ? $this->moneyFormatter($total) : $total;
        // dd($test);
        return $formatter ? $this->moneyFormatter($total) : $total;
    }
}
