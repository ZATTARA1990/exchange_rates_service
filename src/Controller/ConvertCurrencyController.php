<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\ConvertCurrencyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConvertCurrencyController extends AbstractController
{
    public function __construct(private readonly ConvertCurrencyHandler $handler)
    {
    }

    #[Route(path: '/convert-currency', name: 'convertCurrency')]
    public function __invoke(Request $request): Response
    {
        $currencyFrom = $request->get('currency_from');
        $currencyTo = $request->get('currency_to');
        $amount = $request->get('amount');

        $conversion = $this->handler->convert($currencyFrom, $currencyTo, $amount);

        return $this->json($conversion);
    }
}
