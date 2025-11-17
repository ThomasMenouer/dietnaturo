<?php

namespace App\Application\Blog\MessageHandler;

use App\Application\Blog\Message\SyncInstagramMediaMessage;
use App\Infrastructure\Instagram\InstagramMediaService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
final class SyncInstagramMediaMessageHandler
{
    public function __construct(
        private InstagramMediaService $mediaService,
        private LoggerInterface $logger,
    ) {}

    public function __invoke(SyncInstagramMediaMessage $message): void
    {
        try {
            $count = $this->mediaService->syncMedia();
            $this->logger->info(sprintf('✅ %d posts Instagram synchronisés.', $count));
        } catch (\Throwable $e) {
            $this->logger->error('❌ Échec de la synchronisation Instagram : ' . $e->getMessage());
        }
    }
}
