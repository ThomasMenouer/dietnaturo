<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\ConditionsGeneralesVente;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Pages\Repository\ConditionsGeneralesVenteRepositoryInterface;
use App\Domain\Pages\Entity\ConditionsGeneralesVente\ConditionsGeneralesVente;


/**
 * @extends ServiceEntityRepository<ConditionsGeneralesVente>
 */
class ConditionsGeneralesVenteRepository extends ServiceEntityRepository implements ConditionsGeneralesVenteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionsGeneralesVente::class);
    }

    public function getConditionsGeneralesVente(): ConditionsGeneralesVente
    {
        return $this->findOneBy(['id' => 1]);
    }

}
