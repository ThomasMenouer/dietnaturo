<?php


namespace App\Domain\NewsletterSubscriber\Repository;

use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;


interface NewsletterSubscriberRepositoryInterface
{
    
    /**
     * Retourne un abonné par son email
     */

    public function findOneByEmail(string $email): ?NewsletterSubscriber;

    /**
     * Retourne tous les abonnés à la newsletter
     * @return array
     */
    public function findAllEmails(): array;

}