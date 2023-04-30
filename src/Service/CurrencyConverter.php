<?php

declare(strict_types=1);

namespace App\Service;

class CurrencyConverter
{
    public function __construct(private readonly string $baseCurrency, private readonly Calculator $calculator)
    {
    }

    public function convert($amount, $rate): float
    {
        return $this->calculator->multiplyNums($amount, $rate);
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }
}
