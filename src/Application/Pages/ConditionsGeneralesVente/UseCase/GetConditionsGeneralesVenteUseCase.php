<?php 


namespace App\Application\Pages\ConditionsGeneralesVente\UseCase;

use App\Domain\Pages\Entity\ConditionsGeneralesVente\ConditionsGeneralesVente;
use App\Domain\Pages\Repository\ConditionsGeneralesVenteRepositoryInterface;

class GetConditionsGeneralesVenteUseCase
{

    public function __construct(private ConditionsGeneralesVenteRepositoryInterface $conditionsGeneralesVenteRepositoryInterface){}

    public function execute(): ConditionsGeneralesVente
    {
        return $this->conditionsGeneralesVenteRepositoryInterface->getConditionsGeneralesVente();
    }
}