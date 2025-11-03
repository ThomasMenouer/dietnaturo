<?php

namespace App\Infrastructure\Framework\Symfony\Command\Instagram;

use App\Infrastructure\Instagram\InstagramMediaService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:instagram:sync', description: 'Synchronise les posts Instagram dans la base')]
class SyncInstagramCommand extends Command
{
    private InstagramMediaService $service;

    public function __construct(InstagramMediaService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $this->service->syncMedia();
        $output->writeln("<info>$count nouveaux posts importés.</info>");
        return Command::SUCCESS;
    }
}
