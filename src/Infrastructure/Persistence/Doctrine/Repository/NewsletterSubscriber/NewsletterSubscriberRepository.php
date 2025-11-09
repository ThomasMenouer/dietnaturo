<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\NewsletterSubscriber;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\NewsletterSubscriber\Repository\NewsletterSubscriberRepositoryInterface;

/**
 * @extends ServiceEntityRepository<NewsletterSubscriber>
 
 */
class NewsletterSubscriberRepository extends ServiceEntityRepository implements NewsletterSubscriberRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, NewsletterSubscriber::class);
        $this->em  = $em;
    }

    public function save(NewsletterSubscriber $subscriber): void
    {
        $this->em->persist($subscriber);
        $this->em->flush();
    }

    public function remove(NewsletterSubscriber $subscriber): void
    {
        $this->em->remove($subscriber);
        $this->em->flush();
    }

    public function findOneByUnsubscribeToken(string $token): ?NewsletterSubscriber
    {
        return $this->findOneBy(['unsubscribeToken' => $token]);
    }

    public function findOneByEmail(string $email): ?NewsletterSubscriber
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Retourne tous les abonnés à la newsletter
     * @return array
     */
    public function findAllEmails(): array
    {
        return $this->findAll();
    }
}
