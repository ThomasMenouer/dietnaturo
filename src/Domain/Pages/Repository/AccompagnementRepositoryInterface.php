<?php

namespace App\Domain\Pages\Repository;

use App\Domain\Pages\Entity\Accompagnement\Accompagnement;

interface AccompagnementRepositoryInterface
{
    /**
     * Retourne tous les accompagnements ordonnés par position croissante
     * @return array<Accompagnement>
     */
    public function findAllAccompagnement(): array;
}
