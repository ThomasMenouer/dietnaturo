<?php


namespace App\Domain\Pages\Repository;

use App\Domain\Pages\Entity\MentionsLegales\MentionsLegales;

interface MentionsLegalesRepositoryInterface
{
    public function getMentionsLegales(): MentionsLegales; 
}

