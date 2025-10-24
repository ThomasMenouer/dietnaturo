<?php 


namespace App\Application\Pages\PolitiqueConfidentialite\UseCase;

use App\Domain\Pages\Entity\PolitiqueConfidentialite\PolitiqueConfidentialite;
use App\Domain\Pages\Repository\PolitiqueConfidentialiteRepositoryInterface;

class GetPolitiqueConfidentialiteUseCase
{

    public function __construct(private PolitiqueConfidentialiteRepositoryInterface $politiqueConfidentialiteRepositoryInterface){}

    public function execute(): PolitiqueConfidentialite
    {
        return $this->politiqueConfidentialiteRepositoryInterface->getPolitiqueConfidentialite();
    }
}