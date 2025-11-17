<?php


namespace App\Application\Newsletter\UseCase;

use App\Domain\NewsletterSubscriber\Repository\NewsletterSubscriberRepositoryInterface;


final class RemoveSubscriberUseCase
{
    public function __construct(private NewsletterSubscriberRepositoryInterface $newsletterSubscriberRepositoryInterface) {}

    public function execute(string $token): bool
    {
        $subscriber = $this->newsletterSubscriberRepositoryInterface->findOneByUnsubscribeToken($token);
        
        if ($subscriber) {

            $this->newsletterSubscriberRepositoryInterface->remove($subscriber);

            return true;
        }

        return false;
    }
}

