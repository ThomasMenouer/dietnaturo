<?php

namespace App\Application\Newsletter\UseCase;

use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use App\Domain\NewsletterSubscriber\Repository\NewsletterSubscriberRepositoryInterface;

class RegisterNewsletterSubscriberUseCase
{
    public function __construct(private NewsletterSubscriberRepositoryInterface $newsletterSubscriberRepositoryInterface) {}

    public function execute(string $email): string
    {
        $existing = $this->newsletterSubscriberRepositoryInterface->findOneByEmail($email);
        if ($existing) {
            return 'already_registered';
        }

        $subscriber = new NewsletterSubscriber($email);
        $this->newsletterSubscriberRepositoryInterface->save($subscriber);

        return 'success';
    }
}
