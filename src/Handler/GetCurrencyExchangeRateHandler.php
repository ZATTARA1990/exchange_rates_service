<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\CurrencyExchangeRate;
use App\Service\Calculator;
use App\Service\CurrencyConverter;
use App\Service\DatabaseManager\DatabaseManagerInterface;

class GetCurrencyExchangeRateHandler
{
    public function __construct(
        private readonly DatabaseManagerInterface $databaseManager,
        private readonly CurrencyConverter $currencyConverter,
        private readonly Calculator $calculator,
    ) {
    }

    /**
     * @param string $baseCurrency
     *
     * @return CurrencyExchangeRate[]
     */
    public function getRates(string $baseCurrency): array
    {
        $currencyExchangeRates = $this->databaseManager->list(CurrencyExchangeRate::class);

        if ($baseCurrency === $this->currencyConverter->getBaseCurrency()) {
            return $this->formResponse($currencyExchangeRates);
        }

        if (!isset($currencyExchangeRates[$baseCurrency])) {
            return [];
        }

        $currentCurrencyToUsdRate = $currencyExchangeRates[$baseCurrency]->inverseRate;

        return $this->formResponse($currencyExchangeRates, $currentCurrencyToUsdRate);
    }

    private function formResponse($currencyExchangeRates, $currentCurrencyToUsdRate = 1): array
    {
        return array_reduce(
            $currencyExchangeRates,
            function (array $result, CurrencyExchangeRate $item) use ($currentCurrencyToUsdRate) {
                $rate = $this->calculator->divideNums($item->rate, $currentCurrencyToUsdRate);

                $result[] = [
                    'rate' => $rate,
                    'code' => $item->code
                ];

                return $result;
            },
            []
        );
    }
}