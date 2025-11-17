<?php

namespace App\Infrastructure\Framework\Symfony\Command\Instagram;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Blog\UseCase\RefreshInstagramTokenUseCase;

#[AsCommand(
    name: 'app:instagram:refresh-token',
    description: 'Rafraîchit le token Instagram manuellement.'
)]
class RefreshInstagramTokenCommand extends Command
{
    public function __construct(private RefreshInstagramTokenUseCase $useCase)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $success = $this->useCase->execute();

        if ($success) {
            $output->writeln('<info> Nouveau token généré et sauvegardé.</info>');
            return Command::SUCCESS;
        }

        $output->writeln('<error> Impossible de rafraîchir le token.</error>');
        return Command::FAILURE;
    }
}
