<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\About;


use App\Domain\Pages\Repository\ApprocheRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\About\Approche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Approche>
 */
class ApprocheRepository extends ServiceEntityRepository implements ApprocheRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Approche::class);
    }

    public function getAllApproche(): array
    {
        return $this->findAll();
    }

}
