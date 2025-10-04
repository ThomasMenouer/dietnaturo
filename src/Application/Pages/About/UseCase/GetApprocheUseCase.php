<?php 


namespace App\Application\Pages\About\UseCase;

use App\Domain\Pages\Repository\ApprocheRepositoryInterface;

class GetApprocheUseCase
{

    public function __construct(private ApprocheRepositoryInterface $ApprocheRepository){}

    public function execute(): array
    {
        return $this->ApprocheRepository->getAllApproche();
    }
}