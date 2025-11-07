<?php

namespace App\Application\Newsletter\UseCase;

use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use App\Infrastructure\Persistence\Doctrine\Repository\NewsletterRepository\NewsletterSubscriberRepository;



class GetAllEmailsUseCase
{
    public function __construct(private NewsletterSubscriberRepository $repository) {}

    public function execute(): array
    {
        return $this->repository->findAllEmails();

    }
}
