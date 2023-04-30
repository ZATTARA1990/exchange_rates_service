<?php

declare(strict_types=1);

namespace App\Service\Transformer;

use App\Dto\CurrencyExchangeRate;

class FloatratesExchangeResponseTransformer implements ExchangeResponseTransformerInterface
{
    public function transformResponse(array $rawData): array
    {
        return array_reduce($rawData, function (array $result, $item) {
            $code = $item['code'];
            $rate = rtrim(sprintf('%.14f', $item['rate']), '0');
            $inverseRate = rtrim(sprintf('%.14f', $item['inverseRate']), '0');

            $result[$code] = new CurrencyExchangeRate(
                $rate,
                $code,
                $inverseRate,
            );

            return $result;
        }, []);
    }
}
