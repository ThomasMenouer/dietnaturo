<?php

namespace App\Repository\Ateliers;

use App\Entity\Ateliers\DatesAteliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatesAteliers>
 *
 * @method DatesAteliers|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatesAteliers|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatesAteliers[]    findAll()
 * @method DatesAteliers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatesAteliersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatesAteliers::class);
    }

    public function save(DatesAteliers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DatesAteliers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}