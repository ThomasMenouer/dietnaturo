<?php

namespace App\Domain\Pages\Repository;

interface PriceConsultationsRepositoryInterface
{
    /**
     * Renvoie toutes les consultations et leur prix.
     * @return array
     */
    public function getPriceConsultations(): array;
}