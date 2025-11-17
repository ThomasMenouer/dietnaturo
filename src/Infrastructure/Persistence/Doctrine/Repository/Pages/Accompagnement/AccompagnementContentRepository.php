<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Accompagnement;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AccompagnementContent>
 */
class AccompagnementContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccompagnementContent::class);
    }

}
