<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation;


use Doctrine\Persistence\ManagerRegistry;

use App\Domain\Pages\Entity\Consultation\PriceConsultations;
use App\Domain\Pages\Repository\PriceConsultationsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PriceConsultations>
 */
class PriceConsultationsRepository extends ServiceEntityRepository implements PriceConsultationsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceConsultations::class);
    }

    public function getPriceConsultations(): array
    {
        return $this->findAll();
    }
}
