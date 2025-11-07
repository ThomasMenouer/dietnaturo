<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\NewsletterRepository;


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

    public function findOneByEmail(string $email): ?NewsletterSubscriber
    {
        return $this->em->getRepository(NewsletterSubscriber::class)->findOneBy(['email' => $email]);
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
