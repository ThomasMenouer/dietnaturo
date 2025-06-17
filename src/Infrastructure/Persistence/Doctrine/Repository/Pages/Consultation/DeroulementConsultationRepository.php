<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Consultation\DeroulementConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<DeroulementConsultation>
 */
class DeroulementConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeroulementConsultation::class);
    }

    //    /**
    //     * @return DeroulementConsultation[] Returns an array of DeroulementConsultation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DeroulementConsultation
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
