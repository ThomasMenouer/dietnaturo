<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Accompagnement;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use App\Domain\Pages\Repository\AccompagnementRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Accompagnement>
 */
class AccompagnementRepository extends ServiceEntityRepository implements AccompagnementRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accompagnement::class);
    }


    /**
     * Retourne tous les accompagnements
     * @return array<Accompagnement>
     */
    public function findAllAccompagnement(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.pagePosition', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
