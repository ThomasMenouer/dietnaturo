<?php

namespace App\Infrastructure\Framework\Symfony\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Mailers\UseCase\SendAtelierReminderUseCase;

#[AsCommand(
    name: 'app:test-rappel-atelier',
    description: 'Test l’envoi des mails de rappel pour les ateliers du lendemain.'
)]
class TestRappelAtelierCommand extends Command
{
    public function __construct(private SendAtelierReminderUseCase $useCase)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Lancement du test de rappel d’atelier...');
        $this->useCase->execute();
        $output->writeln('Test terminé.');
        return Command::SUCCESS;
    }
}
