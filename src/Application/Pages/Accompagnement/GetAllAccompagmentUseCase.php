<?php

namespace App\Application\Pages\Accompagnement;

use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use App\Domain\Pages\Repository\AccompagnementRepositoryInterface;


/**
 * Récupère tous les accompagnements (pour la navbar ou autre)
 */
final class GetAllAccompagmentUseCase
{
    public function __construct(private AccompagnementRepositoryInterface $repository)
    {
    }


    /**
     * Retourne tous les accompagnements 
     * @return array<Accompagnement>
     */
    public function execute(): array
    {
        return $this->repository->findAllAccompagnement();
    }
}
