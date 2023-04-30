<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\GetCurrencyExchangeRateHandler;
use App\Service\CurrencyConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCurrencyExchangeRateController extends AbstractController
{
    public function __construct(
        private readonly GetCurrencyExchangeRateHandler $handler,
        private readonly CurrencyConverter $currencyConverter,
    ) {
    }

    #[Route(path: '/exchange-rates', name: 'exchangeRates')]
    public function __invoke(Request $request): Response
    {
        $rates = $this->handler->getRates($request->get('base_currency', $this->currencyConverter->getBaseCurrency()));

        return $this->json($rates);
    }
}
