<?php

declare(strict_types=1);

namespace App\Service\Api;

use App\Dto\CurrencyExchangeRate;

interface ExchangeInterface
{
    /**
     * @return CurrencyExchangeRate[]
     */
    public function getCurrencyExchangeRates(): array;
}
