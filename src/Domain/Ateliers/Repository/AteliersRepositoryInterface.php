<?php

namespace App\Domain\Ateliers\Repository;

use App\Domain\Ateliers\Entity\Ateliers;


interface AteliersRepositoryInterface
{
    /**
     * Récupère tous les ateliers.
     *
     * @return Ateliers[]
     */
    public function getAllAteliers(): array;

    /**
     * Trouve un atelier à partir de son slug.
     */
    // public function getAtelierBySlug(string $slug): ?Ateliers;

    /**
     * Persiste ou met à jour un atelier.
     */
    public function save(Ateliers $atelier): void;

    /**
     * Supprime un atelier.
     */
    public function remove(Ateliers $atelier): void;

}