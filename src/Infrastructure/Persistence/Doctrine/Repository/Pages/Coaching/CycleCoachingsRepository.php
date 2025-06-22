<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Coaching;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Coaching\CycleCoachings;
use App\Domain\Pages\Repository\CycleCoachingsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CycleCoachings>
 */
class CycleCoachingsRepository extends ServiceEntityRepository implements CycleCoachingsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CycleCoachings::class);
    }

    public function getAllCycles(): array
    {
        return $this->findAll();
    }
}
