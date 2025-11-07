<?php

namespace App\Application\Newsletter\UseCase;

use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use App\Infrastructure\Persistence\Doctrine\Repository\NewsletterRepository\NewsletterSubscriberRepository;



class RegisterNewsletterSubscriberUseCase
{
    public function __construct(private NewsletterSubscriberRepository $repository) {}

    public function execute(string $email): string
    {
        $existing = $this->repository->findOneByEmail($email);
        if ($existing) {
            return 'already_registered';
        }

        $subscriber = new NewsletterSubscriber($email);
        $this->repository->save($subscriber);

        return 'success';
    }
}
