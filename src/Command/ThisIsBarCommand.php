<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;

#[AsPeriodicTask(1, schedule: 'failure')]
#[AsCommand(
    name: 'this:is:bar',
    description: 'A command that logs "This is bar"',
    aliases: ['is:bar', 'bar',],
)]
class ThisIsBarCommand extends Command
{
    public function __construct(protected LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->logger->info('This is foo');
        return Command::SUCCESS;
    }
}
