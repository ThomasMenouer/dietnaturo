<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Activities;


use App\Domain\Pages\Repository\ActivitiesRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Activities\Activities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Activities>
 */
class ActivitiesRepository extends ServiceEntityRepository implements ActivitiesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activities::class);
    }

    public function getAllActivities(): array
    {
        return $this->findAll();
    }

}
