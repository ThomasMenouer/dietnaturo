<?php


namespace App\Domain\NewsletterSubscriber\Repository;

use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;


interface NewsletterSubscriberRepositoryInterface
{

    /**
     * Enregistre un abonné à la newsletter
     * @param NewsletterSubscriber $subscriber
     * @return void
     */
    public function save(NewsletterSubscriber $subscriber): void;

    /**
     * Supprime un abonné à la newsletter
     * @param NewsletterSubscriber $subscriber
     * @return void
     */
    public function remove(NewsletterSubscriber $subscriber): void;

    /**
     * Retourne un abonné par son token de désinscription
     * @param string $token
     * @return ?NewsletterSubscriber
     */
    public function findOneByUnsubscribeToken(string $token): ?NewsletterSubscriber;
    
    /**
     * Retourne un abonné par son email
     * @param string $email
     * @return ?NewsletterSubscriber
     */
    public function findOneByEmail(string $email): ?NewsletterSubscriber;

    /**
     * Retourne tous les abonnés à la newsletter
     * @return array
     */
    public function findAllEmails(): array;

}