<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Consultation\DeroulementConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Pages\Repository\DeroulementConsultationRepositoryInterface;

/**
 * @extends ServiceEntityRepository<DeroulementConsultation>
 */
class DeroulementConsultationRepository extends ServiceEntityRepository implements DeroulementConsultationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeroulementConsultation::class);
    }

    public function getAllDeroulement(): array
    {
        return $this->findAll();
    }
}
