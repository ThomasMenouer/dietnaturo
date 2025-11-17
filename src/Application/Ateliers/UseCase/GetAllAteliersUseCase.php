<?php

namespace App\Application\Ateliers\UseCase;

use App\Domain\Ateliers\Repository\AteliersRepositoryInterface;

class GetAllAteliersUseCase
{
    public function __construct(private AteliersRepositoryInterface $ateliersRepositoryInterface) {}

    public function getAllAteliers(): array
    {
        return $this->ateliersRepositoryInterface->getAllAteliers();
    }

}
