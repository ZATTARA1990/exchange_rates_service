<?php

declare(strict_types=1);

namespace App\Command;

use App\Handler\UpdateCurrencyExchangeRateHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:update-currency-exchange-rate')]
class UpdateCurrencyExchangeRateCommand extends Command
{
    public function __construct(private readonly UpdateCurrencyExchangeRateHandler $handler)
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->update();

        return Command::SUCCESS;
    }
}
