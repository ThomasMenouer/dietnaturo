<?php 


namespace App\Application\Pages\About\UseCase;

use App\Domain\Pages\Repository\AboutRepositoryInterface;

class GetAboutUseCase
{

    public function __construct(private AboutRepositoryInterface $aboutRepository){}

    public function execute(): array
    {
        return $this->aboutRepository->getAllAbout();
    }
}