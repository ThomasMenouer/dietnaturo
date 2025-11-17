<?php


namespace App\Infrastructure\Framework\Symfony\Command\Instagram;

use App\Infrastructure\Instagram\InstagramTokenService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'app:instagram:exchange-token')]
class ExchangeInstagramTokenCommand extends Command
{
    public function __construct(private InstagramTokenService $instagramTokenService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question(' Entrez le token court Instagram : ');
        $shortLivedToken = $helper->ask($input, $output, $question);

        if (!$shortLivedToken) {
            $output->writeln('<error> Aucun token fourni.</error>');
            return Command::FAILURE;
        }

        $longLivedToken = $this->instagramTokenService->exchangeShortLivedToken($shortLivedToken);

        if ($longLivedToken) {
            $output->writeln('<info> Token long-lived généré et sauvegardé dans var/instagram_token.json !</info>');
            return Command::SUCCESS;
        }

        $output->writeln('<error> Échec de génération du token long-lived.</error>');
        return Command::FAILURE;
    }
}
