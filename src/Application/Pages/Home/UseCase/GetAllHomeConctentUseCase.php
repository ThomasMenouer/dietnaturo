<?php 


namespace App\Application\Pages\Home\UseCase;

use App\Domain\Pages\Repository\HomeRepositoryInterface;

class GetAllHomeConctentUseCase
{

    public function __construct(private HomeRepositoryInterface $homeRepositoryInterface){}

    public function execute(): array
    {
        return $this->homeRepositoryInterface->getAllHomeContent();
    }
}