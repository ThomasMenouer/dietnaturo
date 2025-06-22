<?php 

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Categories;


interface CategoriesRepositoryInterface
{
    /**
     * Persiste une catégorie.
     * @param Categories $categories
     * @return void
     */
    public function save(Categories $categories): void;

    /**
     * Supprime une catégorie.
     * @param Categories $categories
     * @return void
     */
    public function remove(Categories $categories): void;

    /**
     * Récupère tous les catégories.
     * @return array
     */
    public function getAllCategories(): array;
}
