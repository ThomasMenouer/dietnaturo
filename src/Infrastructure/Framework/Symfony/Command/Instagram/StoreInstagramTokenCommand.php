<?php

namespace App\Infrastructure\Framework\Symfony\Command\Instagram;

use App\Infrastructure\Instagram\InstagramTokenService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'app:instagram:store-token', description: 'Stocke un token long-lived Instagram')]
class StoreInstagramTokenCommand extends Command
{
    public function __construct(private InstagramTokenService $instagramTokenService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question('Entrez le token long-lived Instagram : ');
        $token = $helper->ask($input, $output, $question);

        if (!$token) {
            $output->writeln('<error> Aucun token fourni.</error>');
            return Command::FAILURE;
        }

        // On utilise 60 jours pour la durée du token long-lived (en secondes)
        $expiresIn = 60 * 24 * 60 * 60;
        $this->instagramTokenService->storeTokenManually($token, $expiresIn);

        $output->writeln('<info> Token stocké avec succès dans var/instagram_token.json !</info>');
        return Command::SUCCESS;
    }
}