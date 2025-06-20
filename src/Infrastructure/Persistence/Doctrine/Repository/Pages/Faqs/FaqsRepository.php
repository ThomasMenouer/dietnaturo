<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Faqs;


use App\Domain\Pages\Entity\Faqs\Faqs;
use App\Domain\Pages\Repository\FaqsRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Faqs>
 */
class FaqsRepository extends ServiceEntityRepository implements FaqsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faqs::class);
    }


    public function getAllFaqs(): array
    {
        return $this->findAll();
    }
}


