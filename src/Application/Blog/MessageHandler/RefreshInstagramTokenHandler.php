<?php

namespace App\Application\Blog\MessageHandler;


use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Application\Blog\Message\RefreshInstagramTokenMessage;
use App\Application\Blog\UseCase\RefreshInstagramTokenUseCase;

#[AsMessageHandler]
final class RefreshInstagramTokenHandler
{
    public function __construct(private RefreshInstagramTokenUseCase $useCase) {}

    public function __invoke(RefreshInstagramTokenMessage $message): void
    {
        $this->useCase->execute();
    }
}
