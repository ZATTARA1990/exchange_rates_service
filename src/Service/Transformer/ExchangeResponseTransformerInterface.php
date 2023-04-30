<?php

declare(strict_types=1);

namespace App\Service\Transformer;

interface ExchangeResponseTransformerInterface
{
    /**
     * @param array $rawData
     * @return array UsdExchangeRate[]
     */
    public function transformResponse(array $rawData): array;
}
