<?php

declare(strict_types=1);

namespace App\Service\Transformer;

use App\Dto\CurrencyExchangeRate;
use App\Service\Calculator;
use App\Service\CurrencyConverter;

class CoinpaprikaExchangeResponseTransformer implements ExchangeResponseTransformerInterface
{
    public function __construct(
        private readonly Calculator $calculator,
        private readonly CurrencyConverter $currencyConverter
    ) {
    }

    public function transformResponse(array $rawData): array
    {
        return array_reduce($rawData, function (array $result, $item) {
            $needle = '/'.$this->currencyConverter->getBaseCurrency();
            if (!str_contains($item['pair'], $needle)) {
                return $result;
            }

            $code = str_replace($needle, '', $item['pair']);
            $rate = sprintf('%.14f', $item['quotes'][$this->currencyConverter->getBaseCurrency()]['price']);
            $inverseRate = sprintf('%.14f', (string) $this->calculator->divideNums(1, $rate));

            $result[$code] = new CurrencyExchangeRate(
                rtrim($rate, '0'),
                $code,
                rtrim($inverseRate, '0'),
            );

            return $result;
        }, []);
    }
}
