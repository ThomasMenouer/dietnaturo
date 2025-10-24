<?php


namespace App\Domain\Pages\Repository;

use App\Domain\Pages\Entity\PolitiqueConfidentialite\PolitiqueConfidentialite;

interface PolitiqueConfidentialiteRepositoryInterface
{
    public function getPolitiqueConfidentialite(): PolitiqueConfidentialite; 
}

