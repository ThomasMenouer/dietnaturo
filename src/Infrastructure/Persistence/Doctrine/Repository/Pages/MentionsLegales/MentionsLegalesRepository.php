<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\MentionsLegales;

use App\Domain\Pages\Repository\MentionsLegalesRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\MentionsLegales\MentionsLegales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<MentionsLegales>
 */
class MentionsLegalesRepository extends ServiceEntityRepository implements MentionsLegalesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MentionsLegales::class);
    }

    public function getMentionsLegales(): MentionsLegales
    {
        return $this->findOneBy(['id' => 1]);
    }

}
