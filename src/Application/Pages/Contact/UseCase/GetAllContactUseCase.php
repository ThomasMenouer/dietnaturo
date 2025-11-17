<?php 


namespace App\Application\Pages\Contact\UseCase;

use App\Domain\Pages\Repository\ContactRepositoryInterface;

class GetAllContactUseCase
{

    public function __construct(private ContactRepositoryInterface $ContactRepository){}

    public function execute(): array
    {
        return $this->ContactRepository->getAllContact();
    }
}