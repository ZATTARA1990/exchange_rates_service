<?php

declare(strict_types=1);

namespace App\Dto;

class CurrencyExchangeRate
{
    public function __construct(
        public readonly string $rate,
        public readonly string $code,
        public readonly string $inverseRate,
    ) {
    }
}
