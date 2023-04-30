<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Dto\CurrencyExchangeRate;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CurrencyExchangeRateNormalizer implements NormalizerInterface
{
    /**
     * @param CurrencyExchangeRate $object
     * @param null $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        return [
            'rate' => $object->rate,
            'code' => $object->code,
            'inverseRate' => $object->inverseRate,
        ];
    }

    public function supportsNormalization(mixed $data, $format = null): bool
    {
        return $format === 'json' && $data instanceof CurrencyExchangeRate;
    }
}
