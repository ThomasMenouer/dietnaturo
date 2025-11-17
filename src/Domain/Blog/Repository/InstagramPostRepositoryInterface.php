<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\InstagramPost;

interface InstagramPostRepositoryInterface
{

    /**
     * Récupère les posts Instagram paginés
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function findPaginated(int $page, int $limit): array;

    /**
     * Récupère un post Instagram par son ID
     * @param int $id
     * @return ?InstagramPost
     */
    public function getPostById(int $id): ?InstagramPost;

    /**
     * Compte le nombre total de posts Instagram
     * @return int
     */
    public function countAll(): int;
}