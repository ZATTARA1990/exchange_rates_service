<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\Api\ExchangeInterface;
use App\Service\DatabaseManager\DatabaseManagerInterface;
use Traversable;

class UpdateCurrencyExchangeRateHandler
{
    public function __construct(
        private readonly Traversable $exchangeServices,
        private readonly DatabaseManagerInterface $databaseManager
    ) {
    }

    public function update(): void
    {
        $usdExchangeRates = $this->getRates();
        $this->databaseManager->bulkUpdate($usdExchangeRates);
    }

    private function getRates(): array
    {
        $usdExchangeRates = [];

        foreach ($this->exchangeServices as $exchangeService) {
            /** @var ExchangeInterface $exchangeService */
            $usdExchangeRates[] = $exchangeService->getCurrencyExchangeRates();
        }

        return array_merge([], ...$usdExchangeRates);
    }
}
