<?php

declare(strict_types=1);

namespace App\Service\Api;

use App\Dto\CurrencyExchangeRate;
use App\Service\Transformer\ExchangeResponseTransformerInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractExchangeService
{
    public function __construct(
        private readonly string $url,
        private readonly ExchangeResponseTransformerInterface $responseTransformer,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @return CurrencyExchangeRate[]
     */
    public function getCurrencyExchangeRates(): array
    {
        $rawData = $this->getRawData();

        return $this->responseTransformer->transformResponse($rawData);
    }

    private function getRawData(): array
    {
        $jsonResponse = file_get_contents($this->url);
        if ($jsonResponse === false) {
            $this->logger->error(sprintf('%s did not return response', $this->url));

            return [];
        }

        $rawData = json_decode($jsonResponse, true);

        if (!is_array($rawData)) {
            $this->logger->error(sprintf('%s returned response with incorrect format', $this->url));

            return [];
        }

        return $rawData;
    }
}
