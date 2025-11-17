<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\PolitiqueConfidentialite;

use App\Domain\Pages\Repository\PolitiqueConfidentialiteRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\PolitiqueConfidentialite\PolitiqueConfidentialite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PolitiqueConfidentialite>
 */
class PolitiqueConfidentialiteRepository extends ServiceEntityRepository implements PolitiqueConfidentialiteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PolitiqueConfidentialite::class);
    }

    public function getPolitiqueConfidentialite(): PolitiqueConfidentialite
    {
        return $this->findOneBy(['id' => 1]);
    }

}
