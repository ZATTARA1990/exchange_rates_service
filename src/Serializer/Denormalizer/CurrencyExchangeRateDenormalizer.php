<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Dto\CurrencyExchangeRate;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CurrencyExchangeRateDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $type, $format = null, array $context = []): CurrencyExchangeRate
    {
        return new CurrencyExchangeRate($data['rate'], $data['code'], $data['inverseRate']);
    }

    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $format === 'json' && $type === CurrencyExchangeRate::class;
    }
}
