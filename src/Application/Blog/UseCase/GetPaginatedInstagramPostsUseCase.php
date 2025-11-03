<?php

namespace App\Application\Blog\UseCase;

use App\Domain\Blog\Repository\InstagramPostRepositoryInterface;

class GetPaginatedInstagramPostsUseCase
{
    public function __construct(private InstagramPostRepositoryInterface $instagramPostRepository) {}

    /**
     * Retourne une liste paginée des publications Instagram
     * @param int $page
     * @param int $limit
     * @return array{posts: array, total: int, totalPages: int}
     */
    public function execute(int $page, int $limit): array
    {
        $posts = $this->instagramPostRepository->findPaginated($page, $limit);
        $total = $this->instagramPostRepository->countAll();

        return [
            'posts' => $posts,
            'total' => $total,
            'totalPages' => (int) ceil($total / $limit),
        ];
    }
}
