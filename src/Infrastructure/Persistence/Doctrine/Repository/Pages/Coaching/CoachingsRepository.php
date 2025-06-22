<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Coaching;


use App\Domain\Pages\Repository\CoachingsRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Coaching\Coachings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Coachings>
 */
class CoachingsRepository extends ServiceEntityRepository implements CoachingsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coachings::class);
    }


    public function getAllCoachings(): array
    {
        return $this->findAll();
    }
}
