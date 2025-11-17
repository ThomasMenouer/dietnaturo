<?php


namespace App\Domain\Pages\Repository;

use App\Domain\Pages\Entity\ConditionsGeneralesVente\ConditionsGeneralesVente;

interface ConditionsGeneralesVenteRepositoryInterface
{
    public function getConditionsGeneralesVente(): ConditionsGeneralesVente; 
}

