<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\CurrencyExchangeRate;
use App\Service\Calculator;
use App\Service\CurrencyConverter;
use App\Service\DatabaseManager\DatabaseManagerInterface;

class ConvertCurrencyHandler
{
    public function __construct(
        private readonly DatabaseManagerInterface $databaseManager,
        private readonly CurrencyConverter $currencyConverter,
        private readonly Calculator $calculator,
    ) {
    }

    public function convert(string $currencyFrom, string $currencyTo, string $amount): array
    {
        $usdExchangeRate = $this->databaseManager->list(CurrencyExchangeRate::class);

        if (
            (!isset($usdExchangeRate[$currencyFrom]) && $currencyFrom !== $this->currencyConverter->getBaseCurrency())
            || (!isset($usdExchangeRate[$currencyTo]) && $currencyTo !== $this->currencyConverter->getBaseCurrency())
        ) {
            return [];
        }

        $currencyFromToUsdRate = $currencyFrom === $this->currencyConverter->getBaseCurrency() ? 1 : $usdExchangeRate[$currencyFrom]->inverseRate;
        $usdToCurrencyToExchangeRate = $currencyTo === $this->currencyConverter->getBaseCurrency() ? 1 : $usdExchangeRate[$currencyTo]->rate;

        $convertedToUsdAmount = $this->currencyConverter->convert($amount, $currencyFromToUsdRate);
        $convertedAmount = $this->currencyConverter->convert($convertedToUsdAmount, $usdToCurrencyToExchangeRate);

        return [
            'amount' => $convertedAmount,
            'currency_from' => [
                'rate' => $this->calculator->multiplyNums($currencyFromToUsdRate, $usdToCurrencyToExchangeRate),
                'code' => $currencyFrom,
            ],
            'currency_to' => [
                'rate' => 1,
                'code' => $currencyTo,
            ]
        ];
    }
}
