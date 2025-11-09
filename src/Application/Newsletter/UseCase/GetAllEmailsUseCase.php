<?php

namespace App\Application\Newsletter\UseCase;

use App\Domain\NewsletterSubscriber\Repository\NewsletterSubscriberRepositoryInterface;

class GetAllEmailsUseCase
{
    public function __construct(private NewsletterSubscriberRepositoryInterface $newsletterSubscriberRepositoryInterface) {}

    public function execute(): array
    {
        return $this->newsletterSubscriberRepositoryInterface->findAllEmails();

    }
}
