<?php

namespace App\Application\Ateliers\MessageHandler;


use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Application\Mailers\UseCase\SendAtelierReminderUseCase;
use App\Application\Ateliers\Message\SendAtelierReminderMessage;

#[AsMessageHandler]
final class SendAtelierReminderHandler
{
    public function __construct(private SendAtelierReminderUseCase $useCase) {}

    public function __invoke(SendAtelierReminderMessage $message): void
    {
        $this->useCase->execute();
    }
}
